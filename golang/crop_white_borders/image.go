package main

import (
	"fmt"
	"github.com/h2non/filetype"
	"github.com/nxshock/colorcrop"
	"image"
	"image/color"
	"image/jpeg"
	"image/png"
	"os"
	"path/filepath"
	"strings"
)

type ImageFile struct {
	Path string
	Dir  string
	Ext  string
}

func (imageFile *ImageFile) CropImage() bool {
	defer func() {
		if recover() != nil {
			logger.Warn("Error crop: " + imageFile.Path)
		}
	}()

	sourceFile, err := os.OpenFile(imageFile.Path, os.O_RDWR, 0755)
	defer sourceFile.Close()

	if err != nil {
		logger.Warn(err)

		return false
	}

	head := make([]byte, 261)
	sourceFile.Read(head)
	sourceFile.Seek(0, 0)

	var sourceImage image.Image

	if filetype.IsMIME(head, "image/jpeg") || filetype.IsMIME(head, "image/jpg") {
		sourceImage, _ = jpeg.Decode(sourceFile)
	} else if filetype.IsMIME(head, "image/png") {
		sourceImage, _ = png.Decode(sourceFile)
	} else {
		logger.Warn("Error file type: " + imageFile.Path)

		return false
	}

	croppedImage := colorcrop.CropWithComparator(sourceImage, color.RGBA{255, 255, 255, 255}, 0.05, colorcrop.CmpCIE76)

	sourceBounds := sourceImage.Bounds()
	croppedBounds := croppedImage.Bounds()

	if imageFile.IsChangedFile(sourceBounds.Max.X, sourceBounds.Max.Y, croppedBounds.Max.X, croppedBounds.Max.Y) == false {
		logger.Info("No changes: " + imageFile.Path)

		return false
	}

	croppedFile, err := os.Create(imageFile.Path)

	if err != nil {
		logger.Warn(err)

		return false
	}

	if imageFile.IsPng() {
		err = png.Encode(croppedFile, croppedImage)

		if err != nil {
			logger.Warn(err)

			return false
		}
	}

	if imageFile.IsJpg() {
		err = jpeg.Encode(croppedFile, croppedImage, &jpeg.Options{95})

		if err != nil {
			logger.Warn(err)

			return false
		}
	}

	logger.Info("Cropped: " + imageFile.Path)

	return true
}

func (imageFile *ImageFile) IsChangedFile(originalX, originalY, croppedX, croppedY int) bool {
	if croppedX < originalX-config.Offsets.X {
		return true
	}

	if croppedY < originalY-config.Offsets.Y {
		return true
	}

	return false
}

func (imageFile *ImageFile) IsJpg() bool {
	jpgExtensions := []string{".jpeg", ".jpg"}

	return InArray(imageFile.Ext, jpgExtensions)
}

func (imageFile *ImageFile) IsPng() bool {
	pngExtensions := []string{".png"}

	return InArray(imageFile.Ext, pngExtensions)
}

func (imageFile *ImageFile) RemoveResized() {
	filename := filepath.Base(imageFile.Path)

	filenameWithoutExtension := strings.TrimSuffix(filename, imageFile.Ext)
	filenamePattern := fmt.Sprintf("%s_*", filenameWithoutExtension)

	sizedFiles, err := filepath.Glob(imageFile.Dir + "/" + filenamePattern)
	if err != nil {
		logger.Warn(err)
	}

	if len(sizedFiles) != 0 {
		for _, sizedFile := range sizedFiles {
			err := os.Remove(sizedFile)

			if err != nil {
				logger.Warn(err)
			}

			logger.Info("Deleted: " + sizedFile)
		}
	}
}

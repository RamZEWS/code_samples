package main

import (
	"bufio"
	"gopkg.in/yaml.v2"
	"io/ioutil"
	"log"
	"os"
	"path/filepath"
	"regexp"
	"strings"
)

const (
	FilePattern = `^(([0-9]*)?)\.(jpeg|png|jpg)`
)

type Config struct {
	MaxWorkersCount int `yaml:"max_workers_count"`
	ChannelCapacity int `yaml:"channel_capacity"`
	WorkersDelay    int `yaml:"workers_delay"`
	Offsets         struct {
		X int `yaml:offsets:x`
		Y int `yaml:offsets:y`
	}
}

func getAllOriginalFiles(folderPath string, imageFilesChan chan ImageFile) {
	filepath.Walk(folderPath, func(path string, info os.FileInfo, err error) error {
		match, err := regexp.MatchString(FilePattern, info.Name())
		if err != nil || !match {
			return nil
		}

		ext := strings.ToLower(filepath.Ext(path))
		dir := filepath.Dir(path)

		imageFile := ImageFile{path, dir, ext}

		if imageFile.IsJpg() || imageFile.IsPng() {
			imageFilesChan <- imageFile
		}

		return nil
	})

	close(imageFilesChan)
}

func getFilesFromFile(filePath string, imageFilesChan chan ImageFile) {
	readFile, err := os.Open(filePath)

	if err != nil {
		log.Fatalf("failed to open file: %s", err)
	}

	fileScanner := bufio.NewScanner(readFile)
	fileScanner.Split(bufio.ScanLines)

	for fileScanner.Scan() {
		path := fileScanner.Text()
		ext := strings.ToLower(filepath.Ext(path))
		dir := filepath.Dir(path)

		imageFile := ImageFile{path, dir, ext}
		logger.Info(imageFile)
		if imageFile.IsJpg() || imageFile.IsPng() {
			imageFilesChan <- imageFile
		}
	}

	err = readFile.Close()
	if err != nil {
		log.Fatalf("failed to close file: %s", err)
	}

	close(imageFilesChan)
}

func getConfig(fileName string) Config {
	var config Config

	if fileName == "" {
		logger.Fatal("Path to config is empty")
	}

	yamlFile, err := ioutil.ReadFile(fileName)

	if err != nil {
		logger.Fatal("Error reading config file")
	}

	err = yaml.Unmarshal(yamlFile, &config)
	if err != nil {
		logger.Fatal(err)
	}

	return config
}

func InArray(str string, list []string) bool {
	for _, v := range list {
		if v == str {
			return true
		}
	}

	return false
}

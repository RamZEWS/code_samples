package main

import (
	"flag"
	"github.com/sirupsen/logrus"
	"os"
	"sync"
	"time"
)

var imageFiles = []ImageFile{}
var config = Config{}
var changesFiles = []string{}
var logger = logrus.New()

func main() {
	start := time.Now()

	var configFileName, pathToDir, pathToFile string

	flag.StringVar(&configFileName, "config", "", "YAML file to parse.")
	flag.StringVar(&pathToDir, "path", "", "Path to images directory.")
	flag.StringVar(&pathToFile, "file", "", "Path to images directory.")

	flag.Parse()

	if configFileName == "" {
		logger.Info("Please provide yaml file by using -config option")
	}

	var wg sync.WaitGroup

	config = getConfig(configFileName)

	logger.SetFormatter(&logrus.JSONFormatter{})
	logger.SetOutput(os.Stdout)

	logger.Info("Scanning...")
	imageFilesChan := make(chan ImageFile, config.ChannelCapacity)

	if pathToDir != "" {
		go getAllOriginalFiles(pathToDir, imageFilesChan)
	} else if pathToFile != "" {
		go getFilesFromFile(pathToFile, imageFilesChan)
	} else {
		logger.Fatal("Argument Error: Cannot recognize forder or filelist to crop")
	}

	countWorker := 0
	needCountWorkers := config.MaxWorkersCount
	for {
		if countWorker < needCountWorkers {
			countWorker++

			logger.Info("Worker: ", countWorker)

			wg.Add(1)
			go func() {
				cropImages(imageFilesChan, &countWorker)

				wg.Done()
			}()
		}

		if config.WorkersDelay > 0 {
			time.Sleep(time.Duration(config.WorkersDelay) * time.Millisecond)
		}

		if countWorker == 0 {
			break
		}
	}

	wg.Wait()

	t := time.Now()
	elapsed := t.Sub(start)
	logger.Info(elapsed)

	logger.Info("Done")
}

func cropImages(imageFilesChan chan ImageFile, countWorker *int) {
	for i := 0; i < config.ChannelCapacity; i++ {
		imageFile := <-imageFilesChan
		if imageFile.Path == "" {
			break
		}

		var res = imageFile.CropImage()

		if res == true {
			imageFile.RemoveResized()
		}
	}

	*countWorker--
}

# Simple GCP Image Server

A simple image server based on Google Cloud Platform.

This repo was created from [Slim Framework 3 skeleton application](https://github.com/slimphp/Slim-Skeleton) and for learning to use GCP services.

## Installation

1. Log in Google Cloud Platform
2. Open Google Cloud Shell
3. Clone this repo `git clone git@github.com:<YOUR_ACCOUNT>/simple-gcp-image-server.git`
4. Move to the project `cd simple-gcp-image-server`
5. Deploy it `gcloud app deploy [app.yml]`

## Usage

Send `multipart/form-data` (the part name must be `upload-image`) request to `<YOUR_SERVICE_NAME>/upload`, and you will get response contain `serving_url` in JSON format.

## Contributing

You can run the service with a [local development server](https://cloud.google.com/appengine/docs/standard/python/tools/using-local-server), or on GCP.

## License

WTFPL

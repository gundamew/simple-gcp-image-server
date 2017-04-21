# Simple GCP Image Server

A simple image server based on Google Cloud Platform. It saving files with [Cloud Storage](https://cloud.google.com/storage/), serving images with [App Engine](https://cloud.google.com/appengine/), and record the relationships of files and serving URLs with [Cloud SQL](https://cloud.google.com/sql/).

This repo was created from [Slim Framework 3 skeleton application](https://github.com/slimphp/Slim-Skeleton) and for learning to use GCP services.

## Installation

1. Log in Google Cloud Platform
2. Open Google Cloud Shell
3. Clone this repo `git clone git@github.com:<YOUR_ACCOUNT>/simple-gcp-image-server.git`
4. Move to the project `cd simple-gcp-image-server`
5. `composer install` (You have to install composer first)
6. Rename `src/settings.php.example` to `src/settings.php` and edit it
7. Deploy the service `gcloud app deploy [app.yml]`

## Usage

Send `multipart/form-data` (the part name must be `upload-image`) request to `<YOUR_SERVICE_NAME>/upload`, and you will get response contains `serving_url` in JSON format.

For example (use [HTTPie](https://httpie.org/)):

```shell
# Request
http -f POST 'http://localhost:8080/upload' upload-image@~/path/to/image-file

# Response
{
    "serving_url": "http://localhost:8080/_ah/img/encoded_gs_file:YXBwX2RlZmF1bHRfYnVja2V0LzNkMjNmZGJlMWI1OTc2ZmQ0NTM0NjM2Yzc1MDdkZTI5MDllOWRiZTA="
}
```

## Contributing

You can run the service with a [local development server](https://cloud.google.com/appengine/docs/standard/python/tools/using-local-server), or on GCP.

## License

WTFPL

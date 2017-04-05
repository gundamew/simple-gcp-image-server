# Simple GCP Image Server

A simple image server based on Google Cloud Platform.

This repo was created from [Slim Framework 3 skeleton application](https://github.com/slimphp/Slim-Skeleton) and for learning to use GCP services.

## Installation

1. Log in Google Cloud Platform
2. Open Google Cloud Shell
3. Clone this repo `git clone git@github.com:<YOUR_ACCOUNT>/simple-gcp-image-server.git`
4. Move to the project `cd simple-gcp-image-server`
5. `composer install`
6. Modify the config files
    1. Rename `src/settings.php.example` to `src/settings.php`
    2. Rename `phinx.yml.example` to `phinx.yml`
    3. Edit the config files
6. Run database migrations `vendor/bin/phinx migrate -e development`
7. Deploy the service `gcloud app deploy [app.yml]`

## Usage

Send `multipart/form-data` (the part name must be `upload-image`) request to `<YOUR_SERVICE_NAME>/upload`, and you will get response contain `serving_url` in JSON format.

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

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
    1. :warning: The `availableBuckets` setting would affect the `handlers` in `app.yaml`
7. Create database table
    1. Open Cloud SQL page
    2. Create database
    3. Only allow SSL connection and add your local IP to whitelist
    4. Connect to Cloud SQL from local app (like Sequel Pro) using SSL
    5. Use `database/images.sql` to create table
8. Deploy the service `gcloud app deploy [app.yaml]`

## Usage

Send `multipart/form-data` (the part name must be `upload-image`) request to `<YOUR_SERVICE_NAME>/upload`, and you will get response contains `serving_url` in JSON format.

For example (use [HTTPie](https://httpie.org/)):

```shell
# Request
http -f POST 'http://example.com/upload/default' upload-image@~/path/to/image-file

# Response
{
    "public_link":"https://storage.googleapis.com/default-bucket/3d23fdbe1b5976fd4534636c7507de2909e9dbe0",
    "serving_url": "https://lh3.googleusercontent.com/YXBwX2RlZmF1bHRfYnVja2V0LzNkMjNmZGJlMWI1OTc2ZmQ0NTM0NjM2Yzc1MDdkZTI5MDllOWRiZTA="
}
```

## Todo

1. Valid/Limit requests or anyone can upload any file to server
2. Unit tests

## Contributing

You can run the service with a [local development server](https://cloud.google.com/appengine/docs/standard/python/tools/using-local-server), or on GCP.

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

WTFPL

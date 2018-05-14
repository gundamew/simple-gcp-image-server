# Simple GCP Image Server

A simple image server run in App Engine using the [standard environment](https://cloud.google.com/appengine/docs/php/).

It saving files with [Cloud Storage](https://cloud.google.com/storage/), serving images with [App Engine](https://cloud.google.com/appengine/), and record the relationships of files and serving URLs with [Cloud SQL](https://cloud.google.com/sql/).

This repo was created from [Slim Framework 3 skeleton application](https://github.com/slimphp/Slim-Skeleton) and for learning to use GCP services.

## Install

1. Log in Google Cloud Platform and open Google Cloud Shell
2. Clone this repo
3. Install packages `composer install` (You have to install Composer by hand)
4. Edit `src/settings.php`
5. Run migrations locally via [Cloud SQL Proxy](https://cloud.google.com/sql/docs/mysql/connect-admin-proxy)
    * `phinx migrate --dry-run` will receive error message which is an known issue. Just run it w/o `--dry-run` option
6. Deploy the service `gcloud app deploy [app.yaml]`

## How to Use

Send `multipart/form-data` (the part name must be `upload-image`) request to `<YOUR_SERVICE_NAME>/upload`, and you will get response contains `public_link` and `serving_url` in JSON format, like this:

```json
{
    "public_url": "https://storage.googleapis.com/default-bucket/3d23fdbe1b5976fd4534636c7507de2909e9dbe0",
    "serving_url": "https://lh3.googleusercontent.com/YXBwX2RlZmF1bHRfYnVja2V0LzNkMjNmZGJlMWI1OTc2ZmQ0NTM0NjM2Yzc1MDdkZTI5MDllOWRiZTA="
}
```

### HTTPie

```shell
http -f POST 'http://example.com/upload' upload-image@/path/to/image-file
```

### cURL

```shell
curl -X POST --url http://example.com/upload -H 'content-type: multipart/form-data' -F upload-image=@/path/to/image-file
```

## Todo

1. Valid/Limit requests or anyone can upload any file to server
2. Unit tests

## Contributing

You can run the service with a [local development server](https://cloud.google.com/appengine/docs/standard/python/tools/using-local-server), or on GCP.

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

WTFPL

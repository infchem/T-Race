# T-Race Docker image

## Setup

1. Run `docker-compose up`.
2. Open `http://localhost:8080` in any browser.

If you'd like to have a shell into the container, run `docker exec -it $(docker container ls | grep docker_trace | cut -d' ' -f1) bash`.

Note that in the `typesetter` directory, the important and mostly newly created subdirectories are only `addons`, `api` and `public`.
 
## Development

When developing the plugins locally, you typically aren't the `www-data` user. Thus you can do `sudo chown -R youruser:youruser typesetter` during development and go back using `sudo chown -R www-data:www-data typesetter` when the server needs write access to the files again.

## Application structure

The lighttpd and php configuration files are in the `config` subdirectory. When the Docker container is started, they are applied automatically.

To add a new gadget, first add a new entry in `typesetter/addons/trace-gadgets/Addon.ini` with a new gadget name and class name. Then go to `typesetter/addons/trace-gadgets/TRaceGadgets.php` and add the corresponding class and a function in it with the same name.

In the respective new HTML template in the `templates` subdirectory of the `trace-gadgets` addon, add the markup itself (e.g. buttons, styles etc.) first, then jQuery and then your custom scripts. These may then get JSON data from the API.

The API is REST-like and lies in `typesetter/api/v1.php`. All requests to paths starting with `/api/v1/` are automatically redirected to this script. No GET parameters are used here, instead, HTTP paths are used. For example, to generate vouchers, one requests the `/api/v1/vouchers/generate` endpoint. All API endpoints respond with JSON data, as that's the easiest format to parse using JavaScript.

## Demonstration

Right now, a simple frontend demonstration can be found at `http://localhost:8080/index.php/Demo`.

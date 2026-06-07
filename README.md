# resource-monitor

> Note: resmon-api is Linux only!

Pure PHP system monitoring. CPU, RAM, Disk, Docker Containers, Volumes, Networks.

The webiste uses Tailwind for styling. MariaDB database.

## Requirements

- **Docker**
- [**resmon-api**](https://github.com/maxmilian-sk2/resmon-api) (soft requirement) - the app will function without it, but it will be practically useless
    - Python 3.12+ (resmon-api) runs on python

## Full setup

Assuming docker is already installed and running ([sudo-less](https://docs.docker.com/engine/install/linux-postinstall/) for resmon-api docker monitoring).

**resmon-api**
```bash
git clone https://github.com/maxmilian-sk2/resmon-api
cd resmon-api
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt
cp .env.example .env
# Make .env adjustments to your liking
nano .env
uvicorn main:app --host 0.0.0.0 --port 8000
```
**resource-monitor**
> Edit app/core/Config.php to set an Admin key (allows creating an admin account)

```bash
git clone https://github.com/maxmilian-sk2/resource-monitor
cd resource-monitor
# Make docker-compose.yml adjustments to your liking
docker compose up -d
```

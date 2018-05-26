# Easy WP Theme developing with Webpack and Sass
A simple wordpress boilerplate to get fast started for local `WP` Theme development.

Using `webpack-4` and `docker-compose 3.3` to set up a local `WP` developiong enviroment.

Make sure you have:
- docker-compose 3.3
- npm & node 

## Features
- docker compose
- webpack - 4
- sass
- es8
- browser sync
- site origin page builder custom widget - boilerplate
- custom post - type boilerplate

## Recommened WP - Plugins
- Page builder
- advanced custom fields 

# Getting started

1. clone repo
```bash
git clone 
cd ./alekei-wp-boilerplate
```

2. start docker-compose
```bash
docker-compose up
```

3. cd into theme dir install depenencies and start up dev mode :)
```bash
cd ./alekei-theme
npm install
npm run dev
```

4. start developing a theme and have fun :)

## Theme dir structure

```bash
├── README.md
├── alekei-theme
│   ├── 404.php
│   ├── dist                   
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   ├── img                     # image dir
│   ├── index.php
│   ├── package-lock.json
│   ├── package.json
│   ├── postcss.config.js
│   ├── src
│   │   ├── js                  # js folder 
│   │   └── scss                # sass fodler
│   ├── style.css
│   ├── template-parts
│   │   ├── footer.php
│   │   ├── header.php
│   │   └── single.php
│   ├── webpack.config.js
│   └── widgets
│       └── widget-boilerplate
└── docker-compose.yml
```

## Running for for production
```bash
# npm
npm run build
# yarn
yarn run build

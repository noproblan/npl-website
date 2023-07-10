# noprobLAN Website

This repository contains the current website of _npl.ch_.

## Development Setup

Development can happen individually on a developer machine.  
To run the website locally, we are using docker to achieve a setup similar to the production system.

Run `docker compose up nginx` to have access to the website on `http://localhost:80`.

## Deployment
For deploying the master branch to production use `bash scripts/deploy_prod.sh USER@HOST` from your developer machine.


# HLTV

## About

This project is the implementation of the hltv website for the FarPost CS:GO tournament.
Implemented as part of a pet project.

## Setup

1. Register app at [Faceit Dev](https://developers.faceit.com/apps)
2. Set up `FACEIT_TOKEN` by _Server side API KEY_ from your app
3. **[ADDITIONAL]** To set up XDebug profiler in docker you need to create dir `profiles`
4. `docker-compose up`
5. **[ADDITIONAL]** To view XDebug profiler files just open `localhost:8080`
6. Enjoy

## Feature

1. To add tournament - `localhost/admin`
> EXAMPLE
> 
> url: https://www.faceit.com/en/championship/ed039c03-91e8-45f6-a698-56575512d033/Cyber%20FarPost
> 
> id: ed039c03-91e8-45f6-a698-56575512d033
2. To delete extra matches - `localhost/admin/matches`



FROM node:20

ENV NODE_ENV=development

WORKDIR '/srv/app'

EXPOSE 3000

COPY package.json yarn.lock /

RUN yarn install

COPY . .

CMD yarn run start
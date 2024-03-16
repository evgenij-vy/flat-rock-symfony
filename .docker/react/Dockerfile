FROM node:20

ENV NODE_ENV=development

WORKDIR /srv/react-app

EXPOSE 3000

RUN yarn install

COPY . .

CMD npm run dev
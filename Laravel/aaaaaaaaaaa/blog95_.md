  openapi:
    container_name: openapi
    image: swaggerapi/swagger-ui:latest
    tty: true
    volumes:
      - ./src/dist/:/var/openapi
    environment:
      - SWAGGER_JSON=/var/openapi/openapi.json
      - VIRTUAL_HOST=t-openapi.wel-mother.jp
      - VIRTUAL_PORT=8080
    ports:
      - "8080:8080"
    restart: always
    networks:
      - wel-mother-dev

#  mailhog:
#    container_name: mailhog
#    image: mailhog/mailhog
#    ports:
#      - 8025:8025
FROM mysql:8.0.28

COPY ./init.sql /docker-entrypoint-initdb.d/
COPY ./docker-entrypoint_override.sh ./custom_entrypoint.sh
ENTRYPOINT ["/bin/bash", "./custom_entrypoint.sh"]
CMD ["mysqld"]
EXPOSE 3306
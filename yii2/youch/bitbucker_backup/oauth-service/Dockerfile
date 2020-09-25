FROM java:8-jre
MAINTAINER Evgeny Orlov <kristian.lisov@gmail.com>

ADD ./target/oauth-service.jar /app/
CMD ["java", "-Xmx200m", "-jar", "/app/oauth-service.jar"]

EXPOSE 5000
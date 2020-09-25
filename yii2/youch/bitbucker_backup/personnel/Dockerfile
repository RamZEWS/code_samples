FROM java:8-jre
MAINTAINER Evgeny Orlov <kristian.lisov@gmail.com>

ADD ./target/personnel.jar /app/
CMD ["java", "-Xmx200m", "-jar", "/app/personnel.jar"]

EXPOSE 6000
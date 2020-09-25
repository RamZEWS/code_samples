FROM java:8-jre
MAINTAINER Evgeny Orlov <kristian.lisov@gmail.com>

ADD ./target/eureka.jar /app/
CMD ["java", "-Xmx200m", "-jar", "/app/eureka.jar"]

EXPOSE 8761
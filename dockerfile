FROM donovanbroquin/iut-laravel:laravel

RUN addgroup --gid 1000 laravel && \
    adduser --disabled-password --gecos '' --uid 1000 --gid 1000 laravel

USER laravel:laravel
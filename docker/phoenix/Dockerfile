FROM elixir:1.16-alpine

# Instalacja zależności systemowych
RUN apk add --no-cache build-base git

ENV MIX_ENV=dev LANG=C.UTF-8 SECRET_KEY_BASE=dummy

WORKDIR /app

# Kopiowanie plików zależności
COPY mix.exs mix.lock ./
COPY config config
RUN mix local.hex --force && \
    mix local.rebar --force && \
    mix deps.get

# # Kopiowanie reszty aplikacji
# COPY . .

# Kompilacja
RUN mix deps.compile

WORKDIR /app
RUN mix phx.digest

# Port
EXPOSE 4000

CMD ["mix", "phx.server"]
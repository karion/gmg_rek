defmodule MyGmgApi.Repo do
  use Ecto.Repo,
    otp_app: :my_gmg_api,
    adapter: Ecto.Adapters.Postgres

  use Scrivener, page_size: 10
end

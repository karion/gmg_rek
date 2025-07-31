defmodule MyGmgApi.Repo do
  use Ecto.Repo,
    otp_app: :my_gmg_api,
    adapter: Ecto.Adapters.Postgres
end

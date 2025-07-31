defmodule MyGmgApi.Application do
  # See https://hexdocs.pm/elixir/Application.html
  # for more information on OTP Applications
  @moduledoc false

  use Application

  @impl true
  def start(_type, _args) do
    children = [
      MyGmgApiWeb.Telemetry,
      MyGmgApi.Repo,
      {DNSCluster, query: Application.get_env(:my_gmg_api, :dns_cluster_query) || :ignore},
      {Phoenix.PubSub, name: MyGmgApi.PubSub},
      # Start the Finch HTTP client for sending emails
      {Finch, name: MyGmgApi.Finch},
      # Start a worker by calling: MyGmgApi.Worker.start_link(arg)
      # {MyGmgApi.Worker, arg},
      # Start to serve requests, typically the last entry
      MyGmgApiWeb.Endpoint
    ]

    # See https://hexdocs.pm/elixir/Supervisor.html
    # for other strategies and supported options
    opts = [strategy: :one_for_one, name: MyGmgApi.Supervisor]
    Supervisor.start_link(children, opts)
  end

  # Tell Phoenix to update the endpoint configuration
  # whenever the application is updated.
  @impl true
  def config_change(changed, _new, removed) do
    MyGmgApiWeb.Endpoint.config_change(changed, removed)
    :ok
  end
end

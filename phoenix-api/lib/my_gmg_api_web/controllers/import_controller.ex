defmodule MyGmgApiWeb.ImportController do
  use MyGmgApiWeb, :controller

  alias MyGmgApi.ImportLogic

  def create(conn, _params) do
    urls = %{
      male_firstname: System.get_env("MALE_FIRSTNAME"),
      male_lastname: System.get_env("MALE_LASTNAME"),
      female_firstname: System.get_env("FEMALE_FIRSTNAME"),
      female_lastname: System.get_env("FEMALE_LASTNAME")
    }

    case ImportLogic.run_import(urls) do
      :ok ->
        json(conn, %{status: "import successful"})

      {:error, reason} ->
        conn
        |> put_status(:internal_server_error)
        |> json(%{error: format_error(reason)})
    end
  end

  defp format_error(reason) when is_binary(reason), do: reason
  defp format_error(reason), do: inspect(reason)
end

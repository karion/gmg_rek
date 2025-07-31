defmodule MyGmgApiWeb.UserJSON do
  alias MyGmgApi.App.User

  @doc """
  Renders a list of users.
  """
  def index(%{users: users, meta: meta}) do
    %{
      data: for(user <- users, do: data(user)),
      meta: meta
    }
  end

  @doc """
  Renders a single user.
  """
  def show(%{user: user}) do
    %{data: data(user)}
  end

  defp data(%User{} = user) do
    %{
      id: user.id,
      first_name: user.first_name,
      last_name: user.last_name,
      birthdate: user.birthdate,
      gender: user.gender
    }
  end
end

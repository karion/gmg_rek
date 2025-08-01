defmodule MyGmgApiWeb.UserController do
  use MyGmgApiWeb, :controller

  alias MyGmgApi.App
  alias MyGmgApi.App.User

  action_fallback(MyGmgApiWeb.FallbackController)


  def index(conn, params) do
    page = MyGmgApi.App.list_users(params)
    json(conn, MyGmgApiWeb.UserJSON.index(%{users: page.entries, meta: metadata(page)}))
  end

  defp metadata(data) do
    %{
      page_number: data.page_number,
      page_size: data.page_size,
      total_pages: data.total_pages,
      total_entries: data.total_entries
    }
  end

  def create(conn, %{"user" => user_params}) do
    with {:ok, %User{} = user} <- App.create_user(user_params) do
      conn
      |> put_status(:created)
      |> put_resp_header("location", ~p"/api/users/#{user}")
      |> render(:show, user: user)
    end
  end

  def show(conn, %{"id" => id}) do
    user = App.get_user!(id)
    render(conn, :show, user: user)
  end

  def update(conn, %{"id" => id, "user" => user_params}) do
    user = App.get_user!(id)

    with {:ok, %User{} = user} <- App.update_user(user, user_params) do
      render(conn, :show, user: user)
    end
  end

  def delete(conn, %{"id" => id}) do
    user = App.get_user!(id)

    with {:ok, %User{}} <- App.delete_user(user) do
      send_resp(conn, :no_content, "")
    end
  end
end

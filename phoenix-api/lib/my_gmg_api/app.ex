defmodule MyGmgApi.App do
  @moduledoc """
  The App context.
  """

  import Ecto.Query, warn: false
  alias MyGmgApi.Repo

  alias MyGmgApi.App.User

  @doc """
  Returns the list of users.

  ## Examples

      iex> list_users()
      [%User{}, ...]

  """


  def list_users(params \\ %{}) do
    User
    |> filter_users(params)
    |> Repo.paginate(params)
  end

  defp filter_users(query, params) do
    query
    |> filter_by_gender(params)
    |> filter_by_birthdate(params)
    |> filter_by_search(params)
  end

  defp filter_by_gender(query, %{"gender" => gender}) when is_binary(gender) and gender != "" do
    where(query, [u], u.gender == ^gender)
  end

  defp filter_by_gender(query, _), do: query

  defp filter_by_birthdate(query, %{"birthdate_from" => from, "birthdate_to" => to}) do
    where(query, [u], u.birthdate >= ^from and u.birthdate <= ^to)
  end

  defp filter_by_birthdate(query, _), do: query

  defp filter_by_search(query, %{"search" => term}) when is_binary(term) and term != "" do
    where(query, [u], ilike(u.first_name, ^"%#{term}%") or ilike(u.last_name, ^"%#{term}%"))
  end

  defp filter_by_search(query, _), do: query

  @doc """
  Gets a single user.

  Raises `Ecto.NoResultsError` if the User does not exist.

  ## Examples

      iex> get_user!(123)
      %User{}

      iex> get_user!(456)
      ** (Ecto.NoResultsError)

  """
  def get_user!(id), do: Repo.get!(User, id)

  @doc """
  Creates a user.

  ## Examples

      iex> create_user(%{field: value})
      {:ok, %User{}}

      iex> create_user(%{field: bad_value})
      {:error, %Ecto.Changeset{}}

  """
  def create_user(attrs \\ %{}) do
    %User{}
    |> User.changeset(attrs)
    |> Repo.insert()
  end

  @doc """
  Updates a user.

  ## Examples

      iex> update_user(user, %{field: new_value})
      {:ok, %User{}}

      iex> update_user(user, %{field: bad_value})
      {:error, %Ecto.Changeset{}}

  """
  def update_user(%User{} = user, attrs) do
    user
    |> User.changeset(attrs)
    |> Repo.update()
  end

  @doc """
  Deletes a user.

  ## Examples

      iex> delete_user(user)
      {:ok, %User{}}

      iex> delete_user(user)
      {:error, %Ecto.Changeset{}}

  """
  def delete_user(%User{} = user) do
    Repo.delete(user)
  end

  @doc """
  Returns an `%Ecto.Changeset{}` for tracking user changes.

  ## Examples

      iex> change_user(user)
      %Ecto.Changeset{data: %User{}}

  """
  def change_user(%User{} = user, attrs \\ %{}) do
    User.changeset(user, attrs)
  end
end

defmodule MyGmgApi.AppTest do
  use MyGmgApi.DataCase

  alias MyGmgApi.App

  describe "users" do
    alias MyGmgApi.App.User

    import MyGmgApi.AppFixtures

    @invalid_attrs %{first_name: nil, last_name: nil, birthdate: nil, gender: nil}

    test "list_users/0 returns all users" do
      user = user_fixture()
      assert App.list_users() == [user]
    end

    test "get_user!/1 returns the user with given id" do
      user = user_fixture()
      assert App.get_user!(user.id) == user
    end

    test "create_user/1 with valid data creates a user" do
      valid_attrs = %{first_name: "some first_name", last_name: "some last_name", birthdate: ~D[2025-07-29], gender: "some gender"}

      assert {:ok, %User{} = user} = App.create_user(valid_attrs)
      assert user.first_name == "some first_name"
      assert user.last_name == "some last_name"
      assert user.birthdate == ~D[2025-07-29]
      assert user.gender == "some gender"
    end

    test "create_user/1 with invalid data returns error changeset" do
      assert {:error, %Ecto.Changeset{}} = App.create_user(@invalid_attrs)
    end

    test "update_user/2 with valid data updates the user" do
      user = user_fixture()
      update_attrs = %{first_name: "some updated first_name", last_name: "some updated last_name", birthdate: ~D[2025-07-30], gender: "some updated gender"}

      assert {:ok, %User{} = user} = App.update_user(user, update_attrs)
      assert user.first_name == "some updated first_name"
      assert user.last_name == "some updated last_name"
      assert user.birthdate == ~D[2025-07-30]
      assert user.gender == "some updated gender"
    end

    test "update_user/2 with invalid data returns error changeset" do
      user = user_fixture()
      assert {:error, %Ecto.Changeset{}} = App.update_user(user, @invalid_attrs)
      assert user == App.get_user!(user.id)
    end

    test "delete_user/1 deletes the user" do
      user = user_fixture()
      assert {:ok, %User{}} = App.delete_user(user)
      assert_raise Ecto.NoResultsError, fn -> App.get_user!(user.id) end
    end

    test "change_user/1 returns a user changeset" do
      user = user_fixture()
      assert %Ecto.Changeset{} = App.change_user(user)
    end
  end
end

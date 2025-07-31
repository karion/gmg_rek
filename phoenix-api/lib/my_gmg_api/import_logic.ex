defmodule MyGmgApi.ImportLogic do
  import Ecto.Query
  alias MyGmgApi.Repo
  alias MyGmgApi.App.User

  def run_import(urls) do
    try do
      if recordsExists() do
        raise "Baza ma już dane"
      end

      data = fetch_external_data(urls)

      for _i <- 1..100 do
        # Kobiety ≈ 51,6 % populacji
        if :rand.uniform() < 0.516 do
          # famale
          save_data(
            Enum.random(data[:female_firstname]),
            Enum.random(data[:female_lastname]),
            "female",
            random_date()
          )
        else
          # male
          save_data(
            Enum.random(data[:male_firstname]),
            Enum.random(data[:male_lastname]),
            "male",
            random_date()
          )
        end
      end

      :ok
    rescue
      e ->
        {:error, Exception.message(e)}
    catch
      :exit, reason -> {:error, reason}
      :throw, reason -> {:error, reason}
    end
  end

  defp random_date do
    from = ~D[1970-01-01]
    to = ~D[2024-12-31]

    # Liczba dni między datami
    range = Date.diff(to, from)
    days_to_add = :rand.uniform(range + 1) - 1

    Date.add(from, days_to_add)
  end

  defp fetch_external_data(urls) do
    Enum.reduce(urls, %{}, fn {key, base_url}, acc_map ->
      names =
        1..5
        |> Enum.flat_map(fn i ->
          paged_url = base_url <> "?page=#{i}"

          request = Finch.build(:get, paged_url)
          response = Finch.request(request, MyGmgApi.Finch)

          case response do
            {:ok, %Finch.Response{status: 200, body: body}} ->
              data = Jason.decode!(body)["data"]

              Enum.map(data, fn item ->
                String.capitalize(item["attributes"]["col1"]["val"])
              end)

            {:ok, %Finch.Response{status: status}} when status >= 400 ->
              raise "Error fetching data from #{paged_url}: #{status}"

            {:error, reason} ->
              raise "Failed to fetch data from #{paged_url}: #{inspect(reason)}"
          end
        end)

      Map.put(acc_map, key, names)
    end)
  end

  defp save_data(first_name, last_name, gender, birthdate) do
    %User{}
    |> User.changeset(%{
      first_name: first_name,
      last_name: last_name,
      gender: gender,
      birthdate: birthdate
    })
    |> Repo.insert!()
  end

  defp recordsExists do
    Repo.exists?(from(s in User))
  end
end

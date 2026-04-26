# Warehouse

## Description
We will provide a documentation shortly on our API-Page. 

[API Documentation](https://ifheroes.github.io/ifheroes-apis/)

**Important** 

The project name is Warehouse, but this has nothing to do with a classic data warehouse. Its just a project name we came up with.
 # Player-Warehouse

The Player Data Management endpoint provides the latest player profiles for the Infinityheroes Minecraft server. This endpoint requires an API key and cannot be accessed publicly. The response is a JSON array containing player data items such as the name, UUID, language, game mode data such as coins, etc.

## API Structure

### HTTP Methods Used in the REST API

- **GET**: Retrieves data from the endpoint.
- **POST**: Creates or updates data at the endpoint.
- **DELETE**: Removes data from the endpoint.



### API Levels

| API-Level | Name                                                 |
|-----------|------------------------------------------------------|
| 0         | Basic Data (UUID, ID, ...)                            |
| 1         | Advanced (Language, etc...)                           |
| 2         | Custom (Game Data in JSON Objects) - **Core Only**    |



## Schema for Player Profile in Player-Warehouse

```json
{
    "basicData": {
        "version": "v1",
        "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
        "name": "I_Dev"
    },
    "advancedData": {
        "language": "EN"
    },
    "pluginData": {
        "values": {
            "elicitation": {
                "effects": [
                    "fire",
                    "stoned",
                    "healthregen"
                ],
                "points": 1
            }
        }
    }
}
```

## Endpoints

### Check API-Key

`GET https://api.ifheroes.net/v1/warehouse/?checkauth`

#### Description

Check if the API-Key is valid. 

#### Example Request

```sh
curl -X GET "https://api.ifheroes.net/v1/warehouse/?checkauth" \
     -H "Authorization: Bearer YOUR_API_KEY"
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "API Key is valid!"
}
```

**HTTP Status Code: 401**
```json
{
  "error": "Unauthorized"
}
```


#### Usage

This endpoint is useful for retrieving comprehensive player data from the Infinityheroes server. Developers can use this information to display profile details in their applications or websites.


### Get Player Profile

`GET https://api.ifheroes.net/v1/warehouse/`

#### Description

Retrieve the complete player profile with all available information.

#### Example Request

```sh
curl -X GET "https://api.ifheroes.net/v1/warehouse/?uuid={UUID}" \
     -H "Authorization: Bearer YOUR_API_KEY"
```

#### Example Response

```json
{
  "basicData": {
    "version": "v1",
    "uuid": "cc0cf164-e630-498b-8f11-4f6a52467a77",
    "name": "I_Dev"
  },
  "advancedData": {
    "language": "DE"
  },
  "pluginData": {
    "values": "{\"coretest\":{\"coins\":100}}"
  }
}
```

#### Response Parameters

**basicData**
- `version`: A string representing the version that last modified this data set.
- `uuid`: A string representing the UUID of the player. This UUID is provided by Mojang and is the primary identifier for the player in the warehouse.
- `name`: A string representing the name of the player.

**advancedData**
- `language`: A string representing the current language of the player on the server.

**pluginData**
- `values`: A JSON string handled by the Infinityheroes core plugin. The structure may vary for each player profile.

#### Usage

This endpoint is useful for retrieving comprehensive player data from the Infinityheroes server. Developers can use this information to display profile details in their applications or websites.

### Delete player profile

`DELETE https://api.ifheroes.net/v1/warehouse/`

#### Description

Delete the complete player profile with all available information from the player warehouse.

#### Example Request

```sh
curl -X DELETE "https://api.ifheroes.net/v1/warehouse/?delete={UUID}" \
     -H "Authorization: Bearer YOUR_API_KEY"
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Profile deleted"
}
```

**HTTP Status Code: 403**
```json
{
  "error": "Needs to be a DELETE"
}
```

#### Usage

This endpoint is useful for deleting comprehensive player data from the Infinityheroes server. This function is only available for developers on our test systems. The production system delets player data with our core. https://github.com/ifheroes/core


### Post a New Player Profile

`POST https://api.ifheroes.net/v1/warehouse/`

#### Description

Creates a new basic player profile in the warehouse.

#### Example Request

```sh
curl -H 'Content-Type: application/json' \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -d '{
           "section": "newPlayerData",
           "schema": {
             "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
             "name": "I_Dev"
           }
         }' \
     -X POST \
     https://api.ifheroes.net/v1/warehouse/
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Profile created successfully!"
}
```

**HTTP Status Code: 403**
```json
{
  "error": "Profile already exists in storage!"
}
```

#### Response Parameters

- **success**: A string indicating that the profile was successfully created.
- **error**: A string indicating that the profile already exists in storage.

#### Usage

This endpoint is useful for creating new player profiles in the Infinityheroes server warehouse. Developers can integrate this functionality into registration systems or administrative tools.

### Update Profile BasicData

`POST https://api.ifheroes.net/v1/warehouse/`

#### Description

Updates the basic values of a player profile. Currently, only the player **name** can be updated.

#### Example Request

```sh
curl -H 'Content-Type: application/json' \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -d '{
           "section": "basicData",
           "schema": {
             "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
             "name": "New_Name"
           }
         }' \
     -X POST \
     https://api.ifheroes.net/v1/warehouse/
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Player data updated successfully"
}
```

**HTTP Status Code: 403**
```json
{
  "error": "Profile not found or unauthorized access!"
}
```

#### Response Parameters

- **success**: A string indicating that the profile was successfully updated.
- **error**: A string indicating that the profile was not found or access is forbidden.

#### Usage

This endpoint allows for updating basic player information, such as the player's name. It is useful for administrative purposes or when players change their usernames.

### Delete a Player Profile

`DELETE https://api.ifheroes.net/v1/warehouse/`

#### Description

Deletes an existing player profile from the warehouse.

#### Example Request

```sh
curl -X DELETE "https://api.ifheroes.net/v1/warehouse/?delete={UUID}" \
     -H "Authorization: Bearer YOUR_API_KEY"
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Player data updated successfully"
}
```

**HTTP Status Code: 404**
```json
{
  "error": "Failed to update player data"
}
```

#### Response Parameters

- **success**: A string indicating that the profile was successfully deleted.
- **error**: A string indicating that the profile was not found.

#### Usage

This endpoint is useful for removing player profiles from the Infinityheroes server warehouse. It can be integrated into account deletion processes or administrative tools.

### Update AdvancedData

`POST https://api.ifheroes.net/v1/warehouse/`

#### Description

Updates the advanced values of a player profile, such as language preferences.

#### Example Request

```sh
curl -H 'Content-Type: application/json' \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -d '{
           "section": "advancedData",
           "schema": {
             "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
             "language": "EN"
           }
         }' \
     -X POST \
     https://api.ifheroes.net/v1/warehouse/
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Player data updated successfully"
}
```

**HTTP Status Code: 403**
```json
{
  "error": "Failed to update player data"
}
```

#### Response Parameters

- **success**: A string indicating that the advanced data was successfully updated.
- **error**: A string indicating that the profile was not found or access is forbidden.

#### Usage

This endpoint allows for updating advanced player information, such as language settings. It is useful for localization features or user preference management.

### Update PluginData

`POST https://api.ifheroes.net/v1/warehouse/`

#### Description

Updates the plugin-specific data of a player profile. This section is **only available for the Core**.

#### Example Request

```sh
curl -H 'Content-Type: application/json' \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -d '{
           "section": "pluginData",
           "schema": {
             "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
             "updater": {
               "test": true
             }
           }
         }' \
     -X POST \
     https://api.ifheroes.net/v1/warehouse/
```

#### Example Response

**HTTP Status Code: 200**
```json
{
  "success": "Player data updated successfully"
}
```

**HTTP Status Code: 403**
```json
{
  "error": "Failed to update player data"
}
```

#### Response Parameters

- **success**: A string indicating that the plugin data was successfully updated.
- **error**: A string indicating unauthorized access or failure to update.

#### Usage

This endpoint is intended for updating plugin-specific data within the player profile. It is primarily used by the Core system to manage game-related data.

## Additional Notes

- **Authentication**: All endpoints require an API key. Include it in the `Authorization` header as a Bearer token.

  ```sh
  -H "Authorization: Bearer YOUR_API_KEY"
  ```

- **Content-Type**: Ensure that all POST and DELETE requests include the appropriate `Content-Type` header, typically `application/json`.

- **Error Handling**: Always handle possible error responses (e.g., 403 Forbidden, 404 Not Found) gracefully in your application to ensure a robust user experience.

- **Rate Limiting**: Be aware of any rate limits imposed by the API to avoid being throttled or blocked.

- **Data Validation**: Validate all data before sending requests to ensure it adheres to the expected schema, reducing the likelihood of errors.

- **Security**: Keep your API key secure. Do not expose it in client-side code or public repositories.

## Example Schemas

### Schema for Retrieving a Player Profile (GET)

The URL is an example URL that must be queried with the known key.

```
https://api.ifheroes.net/v1/warehouse?uuid=41e84db3-3d9a-4123-a070-22bcf28efe16
```

### Schema for Creating a New Player Profile (POST)

```json
{
  "section": "newPlayerData",
  "schema": {
    "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
    "name": "I_Dev"
  }
}
```

### Schema for Updating BasicData (POST)

```json
{
  "section": "basicData",
  "schema": {
    "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
    "name": "New_Name"
  }
}
```

### Schema for Updating AdvancedData (POST)

```json
{
  "section": "advancedData",
  "schema": {
    "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
    "language": "EN"
  }
}
```

### Schema for Updating PluginData (POST)

```json
{
  "section": "pluginData",
  "schema": {
    "uuid": "504bf585-2d78-4ef7-864f-71eb47ccef4e",
    "updater": {
      "test": true
    }
  }
}
```

## Contact & Support

For further assistance or inquiries, please contact our support team via our [Discord server](https://ifheroes.de/discord).

This documentation provides a comprehensive overview of the `https://api.ifheroes.net/v1/warehouse/` endpoint, including its usage, response formats, and example requests and responses. Ensure that your application adheres to the provided schemas and handles responses appropriately for seamless integration with the Infinityheroes server.

# API REST with Docker & MySQL

Este es un ejemplo de como se puede montar un API REST con PHP y MySQL sobre Docker, utilizando Docker Compose.

Para esta demostración se tomó el código de https://github.com/iespino00/API-REST-with-PHP y se adaptó para poder utilizarse con Docker.


## API Reference

#### Ver todas las personas

```http
  GET /peoples
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key` | `string` | **Required**. Your API key |

#### Ver persona especifica

```http
  GET /peoples/id/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Agregar una nueva persona

```http
  POST /peoples
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`API_KEY`

`ANOTHER_API_KEY`


## Authors

- [@octokatherine](https://www.github.com/octokatherine)


## 🚀 About Me
I'm a full stack developer...


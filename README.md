# Full Stack Mid-Test : Todo App Api Service

## Setup Instructions

Run Database Migrations <br /><br />
`php artisan migrate`
<br /><br />
Serve the application <br /><br />
`php artisan serve` 


## Resource Endpoints

### 1. List Todos
**GET** `/api/v1/todos`  
*Get list of todos*

**Query Params**:
- `query` (string): Filter by title or description
- `status` (int): Filter by status [0=Pending, 5=In Progress, 10=Done]
- `offset` (int): Pagination offset (default: 0)
- `limit` (int): Items per page (default: 20)

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Buy milk",
      "description": "Get 2% milk",
      "status": 0,
      "done_at": null
    }
  ]
}
```
### 2. Create a Todo
**POST** `/api/v1/todos/store`  
*Store a new Todo*

**Body (JSON)**:
- `title` (string): Title of the todo
- `description` (string): Description of the todo

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Buy milk",
      "description": "Get 2% milk",
      "status": 0
      "done_at": null
    }
  ]
}
```
### 3. Update a Todo
**PATCH** `/api/v1/todos/update/{id}`  
*Update an existing Todo*

**URL Params**:
- `id` (int): Todo ID

**Body (JSON)**:
- `title` (string): Title of the todo
- `description` (string): Description of the todo
- `status` (int): Update the status [0=Pending, 5=In Progress, 10=Done]

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Buy milk",
      "description": "Get 2% milk",
      "status": 10
      "done_at": "2025-03-26"
    }
  ]
}
```
### 4. Delete a Todo
**DELETE** `/api/v1/todos/update/{id}`  
*Delete an existing Todo*

**URL Params**:
- `id` (int): Todo ID


**Response**:
```json
{
  "data": [], 
  "message" : "Todo Deleted Successfully"
}
```

<?php

class BooksController
{
    public function index($mysqli)
    {
        header('Content-Type: application/json');
        $result = $mysqli->query("SELECT b.id, b.name, b.description, p.id as 'publisherId', p.name as 'publisherName' FROM books b JOIN publishers p ON b.publisherId = p.id ORDER BY b.name");
        $books = [];

        while ($row = $result->fetch_assoc()) {
            $books[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'publisher' => [
                    'id' => $row['publisherId'],
                    'name' => $row['publisherName'],
                ],
            ];
        }
        echo json_encode($books);
    }

    public function listOneById($mysqli, $id)
    {
        header('Content-Type: application/json');
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();

        $book  = $stmt->get_result()->fetch_assoc();

        if (!$book) {
            http_response_code(404);
            echo json_encode(['message' => 'Não foi encontrado nenhum item com esse ID']);
            return;
        }
        echo json_encode($book);

        $stmt->close();
    }

    public function listByName($mysqli, $name)
    {
        header('Content-Type: application/json');
        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("SELECT b.id, b.name, b.description, p.id as 'publisherId', p.name as 'publisherName' FROM books b JOIN publishers p ON b.publisherId = p.id WHERE b.name LIKE ? OR p.name LIKE ? OR b.description LIKE ? ORDER BY b.name");
        $paramName = "%" . $name . "%";
        $stmt->bind_param('sss', $paramName, $paramName, $paramName);

        $result = $stmt->execute();

        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno ao buscar acervo pelo nome.', 'ok' => false]);
            return;
        }

        $queryResult = $stmt->get_result();
        $books = [];

        while ($row = $queryResult->fetch_assoc()) {
            $books[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'publisher' => [
                    'id' => $row['publisherId'],
                    'name' => $row['publisherName'],
                ],
            ];
        }

        echo json_encode($books);

        $stmt->close();
    }

    public function store($mysqli)
    {
        header('Content-Type: application/json');
        if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['publisherId'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $publisherId = $_POST['publisherId'];

            $stmt = $mysqli->prepare("INSERT INTO books (name, description, publisherId) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $description, $publisherId);

            if ($stmt->execute()) {
                $itemid = $stmt->insert_id;
                http_response_code(201);
                echo json_encode(['id' => $stmt->insert_id]);
            } else {
                echo json_encode(['message' => 'Falha ao inserir o acervo.', 'ok' => false]);
            }

            $stmt->close();
        } else {
            echo json_encode(['message' => 'Algum problema ocorreu. Verifique sua conexão e tente novamente']);
        }
    }

    public function update($mysqli, $id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido.']);
            return;
        }

        $stmtCheck = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
        $stmtCheck->bind_param('i', $id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['erro' => 'Acervo não encontrado.']);
            return;
        }

        if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['publisherId'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $publisherId = $_POST['publisherId'];

            $stmt = $mysqli->prepare("UPDATE books SET name=?, description=?, publisherId=? WHERE id=?");
            $stmt->bind_param('sssi', $name, $description, $publisherId, $id);

            try {
                $stmt->execute();
                http_response_code(201);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(['message' => 'Algum erro não esperado ocorreu. Aguarde alguns instantes e tente novamente', 'ok' => false, 'trace' => $th]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Erro no formulário! Esqueceu de preencher algum campo?']);
        }
    }

    public function delete($mysqli, $id)
    {
        header('Content-Type: application/json');
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['message' => 'ID inválido.']);
            return;
        }

        $stmt = $mysqli->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param('i', $id);

        try {
            $stmt->execute();
            http_response_code(204);
        } catch (Exception $e) {
            if ($stmt->errno === 1451) {
                http_response_code(409);
                echo json_encode(['message' => 'Ocorreu um conflito ao excluir o item', 'ok' => false]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Algum erro não esperado ocorreu. Aguarde alguns instantes e tente novamente', 'ok' => false]);
            }
        }

        $stmt->close();
    }
}

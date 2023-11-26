<?php

class CommonController
{
  public function listByCustomQuery($mysqli, $query)
  {
    header('Content-Type: application/json');
    if (empty($query)) {
      http_response_code(400);
      echo json_encode(['erro' => 'Query inválida']);
      return;
    }

    $stmt = $mysqli->prepare($query);

    $result = $stmt->execute();

    if (!$result) {
      http_response_code(500);
      echo json_encode(['message' => 'Erro interno ao executar a query', 'ok' => false]);
      return;
    }

    $queryResult = $stmt->get_result();
    $list = [];

    while ($row = $queryResult->fetch_assoc()) {
      $list[] = $row;
    }

    echo json_encode($list);

    $stmt->close();
  }
}

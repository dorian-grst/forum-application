<?php
namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\AbstractDataObject;

abstract class AbstractRepository {
    protected abstract function getNomTable(): string;
    protected abstract function construire(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function getNomClePrimaire(): string;
    protected abstract function getNomsColonnes(): array;

    public function rawSqlQuery($sql, $values = []): bool | \PDOStatement {
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        return $pdoStatement;
    }

    public function rowCount($sql, $values): int {
        $pdoStatement = self::rawSqlQuery($sql, $values);
        return $pdoStatement->rowCount();
    }

    public function selectMultiple(string $sql, array $values = [], bool $formatted = false) {
        $pdoStatement = $this->rawSqlQuery($sql, $values);
        if (!$formatted) {
            return $pdoStatement->fetchAll();
        }
        $res = [];
        foreach($pdoStatement as $obj) {
            $res[] = $this->construire($obj);
        }
        return $res;
    }

    public function selectSingle(string $sql, array $values = [], bool $formatted = false) {
        $pdoStatement = $this->rawSqlQuery($sql, $values);
        $res = $pdoStatement->fetch();
        if (!$formatted) {
            return $res;
        }
        if(!$res) return null;
        return $this->construire($res);
    }

    public function selectAll(): array {
        $pdoStatement = self::rawSqlQuery("SELECT * FROM " . $this->getNomTable());

        $res = [];

        foreach($pdoStatement as $obj) {
            $res[] = $this->construire($obj);
        }

        return $res;
    }

    public function select(string $valeurClePrimaire): ?AbstractDataObject {
        $sql = "SELECT * from {$this->getNomTable()} WHERE {$this->getNomClePrimaire()}=:clePrimaireTag";
        $values = array(
            "clePrimaireTag" => $valeurClePrimaire,
        );

        $pdoStatement = self::rawSqlQuery($sql, $values);

        $obj = $pdoStatement->fetch();
        return $obj ? $this->construire($obj) : NULL;
    }

    public function delete($valeurClePrimaire) {
        $sql = "DELETE FROM {$this->getNomTable()} WHERE {$this->getNomClePrimaire()}=:clePrimaireTag";
        $values = [
            "clePrimaireTag" => $valeurClePrimaire
        ];
        self::rawSqlQuery($sql, $values);
    }

    public function mettreAJour(AbstractDataObject $object) {

    }
}
?>

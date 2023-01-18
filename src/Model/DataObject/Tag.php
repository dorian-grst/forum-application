<?php
 namespace App\Nig\Model\DataObject;
 
 class Tag extends AbstractDataObject{
     private string $name;
     private ?int $id;
     private int $idQuestion;
     
        public function __construct(?int $id, string $name, int $idQuestion = 0) {
            $this->name = $name;
            $this->id = $id;
            $this->idQuestion = $idQuestion;
        }

        public function getObjectAsArray(): array
        {
            return ["nameTag" => $this->name,
                "idTag" => $this->id
            ];
        }

     public function getName(): String{
            return $this->name;
        }

        public function getId(): ?int{
            return $this->id;
        }

        public function getIdQuestion(): int{
            return $this->idQuestion;
        }

        public function display() : string{
            \ob_start();
            ?>
            <div class="rectangle rectangle--blue"><?php echo $this->name ?></div>
            <?php
            return \ob_get_clean();
        }
 }



?>
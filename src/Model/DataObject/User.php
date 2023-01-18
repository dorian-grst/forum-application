<?php
    namespace App\Nig\Model\DataObject;

    use App\Nig\Model\Repository\DatabaseConnection;

    Class User extends AbstractDataObject {
        protected String $login;
        protected ?String $nameUser;
        protected ?String $email;
        protected ?String $password;
        protected ?String $avatarUrl;

        public function __construct($login,?string $nameUser,?string $email,?string $password,?string $avatarUrl)
        {
            $this->login=$login;
            $this->nameUser=$nameUser;
            $this->email=$email;
            $this->password=$password;
            $this->avatarUrl=$avatarUrl;
        }

        public function getObjectAsArray(): array
        {
            return [
                    "loginUser" => $this->login,
                "name" => $this->nameUser,
                "email" => $this->email,
                "password" => $this->password,
                "avatarUrl" => $this->avatarUrl
            ];
        }

        /**
         * @return String
         */
        public function getLogin(): string
        {
            return $this->login;
        }

        /**
         * @param String $login
         */
        public function setLogin(string $login): void
        {
            $this->login = $login;
        }

        /**
         * @return String
         */
        public function getNameUser(): string
        {
            return $this->nameUser;
        }

        /**
         * @param String $nameUser
         */
        public function setNameUser(string $nameUser): void
        {
            $this->nameUser = $nameUser;
        }

        /**
         * @return String
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * @param String $email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        /**
         * @return String
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * @param String $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        /**
         * @return String
         */
        public function getAvatarUrl(): string
        {
            return $this->avatarUrl;
        }

        /**
         * @param String $avatarUrl
         */
        public function setAvatarUrl(string $avatarUrl): void
        {
            $this->avatarUrl = $avatarUrl;
        }
        public function displayVoters(array $collabs, array $voters): string {
            \ob_start();
            ?>
            <div class="select--head--members flex--row section--title">
                <div class="select--head--members--pseudo">
                    <?php echo $this->nameUser ?>
                </div>
                <div class="flex--row select--head--members--firstdiv">
                    <svg class="add--svg <?php echo (\in_array($this->login, array_merge($voters, $collabs)) ? 'selected' : '') ?>" id="<?php echo $this->login?>" alt="add" onclick="addVoter(this.id)" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.875 7.5C1.875 5.9876 1.875 5.23139 2.07689 4.62027C2.47419 3.41762 3.41762 2.47419 4.62027 2.07689C5.23139 1.875 5.9876 1.875 7.5 1.875V1.875C9.0124 1.875 9.76861 1.875 10.3797 2.07689C11.5824 2.47419 12.5258 3.41762 12.9231 4.62027C13.125 5.23139 13.125 5.9876 13.125 7.5V7.5C13.125 9.0124 13.125 9.76861 12.9231 10.3797C12.5258 11.5824 11.5824 12.5258 10.3797 12.9231C9.76861 13.125 9.0124 13.125 7.5 13.125V13.125C5.9876 13.125 5.23139 13.125 4.62027 12.9231C3.41762 12.5258 2.47419 11.5824 2.07689 10.3797C1.875 9.76861 1.875 9.0124 1.875 7.5V7.5Z" stroke="black" stroke-width="2"/>
                        <path d="M7.5 5L7.5 10" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        <path d="M10 7.5L5 7.5" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                    </svg>

                   </div>
                <div class="flex--row select--head--members--seconddiv">
                    <svg class="add--svg <?php echo \in_array($this->login, $collabs) ? 'selected' : '' ?>" id="<?php echo $this->login."_"?>" alt="add" onclick="addContributor(this.id)" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.875 7.5C1.875 5.9876 1.875 5.23139 2.07689 4.62027C2.47419 3.41762 3.41762 2.47419 4.62027 2.07689C5.23139 1.875 5.9876 1.875 7.5 1.875V1.875C9.0124 1.875 9.76861 1.875 10.3797 2.07689C11.5824 2.47419 12.5258 3.41762 12.9231 4.62027C13.125 5.23139 13.125 5.9876 13.125 7.5V7.5C13.125 9.0124 13.125 9.76861 12.9231 10.3797C12.5258 11.5824 11.5824 12.5258 10.3797 12.9231C9.76861 13.125 9.0124 13.125 7.5 13.125V13.125C5.9876 13.125 5.23139 13.125 4.62027 12.9231C3.41762 12.5258 2.47419 11.5824 2.07689 10.3797C1.875 9.76861 1.875 9.0124 1.875 7.5V7.5Z" stroke="black" stroke-width="2"/>
                        <path d="M7.5 5L7.5 10" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        <path d="M10 7.5L5 7.5" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                    </svg>
                </div>

            </div>
            <?php
            return \ob_get_clean();
        }

        public function displayAutors(): string {
            \ob_start();
            ?>
            <div class="flex--row horizontal--sep" style="justify-content: space-between" onclick="document.location.href='frontController.php?action=deleteAutor&controller=user&loginAutor=<?php echo $this->getLogin()?>'">
                <p> <?php echo $this->getLogin() ?></p>
                <img src="../web/img/croix.png" alt="croix" style="width: 14px; height: 14px;margin-top:4px">
            </div>
            <?php
            return \ob_get_clean();
        }



    }


?>
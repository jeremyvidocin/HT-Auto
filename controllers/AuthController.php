<?php
// controllers/AuthController.php
class AuthController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
        //session_start();
    }

    public function showLogin() {
        require_once('./views/auth/login.php');
    }

    public function showRegister() {
        require_once('./views/auth/register.php');
    }

    public function showProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        // Récupérer les informations de l'utilisateur
        $this->user->id = $_SESSION['user_id'];
        $user = $this->user->readOne();
        
        // Message pour nouvel utilisateur
        if (isset($_GET['new']) && $_GET['new'] == 1) {
            $success_message = "Votre compte a été créé avec succès !";
        }
        
        // Message pour mise à jour de profil
        if (isset($_GET['updated']) && $_GET['updated'] == 1) {
            $success_message = "Votre profil a été mis à jour avec succès !";
        }
        
        require_once('./views/auth/profile.php');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $this->user->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                // Ces lignes sont cruciales - vérifiez qu'elles sont présentes
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
                
                header('Location: index.php');
                exit;
            } else {
                $errors = ["Email ou mot de passe incorrect"];
                require_once('./views/auth/login.php');
            }
        } else {
            require_once('./views/auth/login.php');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->firstname = $_POST['firstname'] ?? '';
            $this->user->lastname = $_POST['lastname'] ?? '';
            $this->user->email = $_POST['email'] ?? '';
            $this->user->password = $_POST['password'] ?? '';
            $this->user->phone = $_POST['phone'] ?? '';
            $this->user->address = $_POST['address'] ?? '';
            
            $errors = $this->validateRegistration();
            
            // Vérifier si l'email existe déjà
            $existingUser = $this->user->findByEmail($this->user->email);
            if ($existingUser) {
                $errors[] = "Cet email est déjà utilisé par un autre compte";
            }
            
            if (empty($errors)) {
                if ($this->user->create()) {
                    // Récupérer l'utilisateur nouvellement créé pour avoir son ID
                    $newUser = $this->user->findByEmail($this->user->email);
                    
                    // Connecter automatiquement l'utilisateur
                    $_SESSION['user_id'] = $newUser['id'];
                    $_SESSION['user_name'] = $newUser['firstname'] . ' ' . $newUser['lastname'];
                    
                    // Redirection vers la page d'accueil ou profil
                    header('Location: index.php?action=profile&new=1');
                    exit;
                } else {
                    $errors[] = "Une erreur est survenue lors de la création du compte.";
                }
            }
        }
        
        require_once('./views/auth/register.php');
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    private function validateRegistration() {
        $errors = [];
        
        if (empty($this->user->firstname)) $errors[] = "Le prénom est requis";
        if (empty($this->user->lastname)) $errors[] = "Le nom est requis";
        if (empty($this->user->email)) {
            $errors[] = "L'email est requis";
        } elseif (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format d'email invalide";
        }
        if (empty($this->user->password)) {
            $errors[] = "Le mot de passe est requis";
        } elseif (strlen($this->user->password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }
        
        return $errors;
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $_SESSION['user_id'];
            $this->user->firstname = $_POST['firstname'] ?? '';
            $this->user->lastname = $_POST['lastname'] ?? '';
            $this->user->phone = $_POST['phone'] ?? '';
            $this->user->address = $_POST['address'] ?? '';
            
            if ($this->user->update()) {
                // Mettre à jour aussi le nom affiché dans la session
                $_SESSION['user_name'] = $this->user->firstname . ' ' . $this->user->lastname;
                header('Location: index.php?action=profile&updated=1');
            } else {
                header('Location: index.php?action=profile&error=1');
            }
            exit;
        }
    }
    
    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Récupérer l'utilisateur pour vérifier le mot de passe actuel
            $this->user->id = $_SESSION['user_id'];
            $user = $this->user->readOne();
            
            $errors = [];
            if (!password_verify($current_password, $user['password'])) {
                $errors[] = "Le mot de passe actuel est incorrect";
            }
            
            if ($new_password !== $confirm_password) {
                $errors[] = "Les nouveaux mots de passe ne correspondent pas";
            }
            
            if (strlen($new_password) < 8) {
                $errors[] = "Le nouveau mot de passe doit contenir au moins 8 caractères";
            }
            
            if (empty($errors)) {
                if ($this->user->updatePassword($new_password)) {
                    header('Location: index.php?action=profile&password_updated=1');
                } else {
                    header('Location: index.php?action=profile&error=2');
                }
                exit;
            } else {
                // Stocker les erreurs dans la session pour les afficher
                $_SESSION['password_errors'] = $errors;
                header('Location: index.php?action=profile');
                exit;
            }
        }
    }
}
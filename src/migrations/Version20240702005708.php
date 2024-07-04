<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702005708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
         // this up() migration is auto-generated, please modify it to your needs
         $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, senha VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, nome VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, sobrenome VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, estado VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, cidade VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, foto VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE compras (id INT AUTO_INCREMENT NOT NULL, data DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, iduser INT DEFAULT NULL, idproduto INT DEFAULT NULL, INDEX idproduto (idproduto), INDEX iduser (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE carrinho (id INT AUTO_INCREMENT NOT NULL, iduser INT DEFAULT NULL, idproduto INT DEFAULT NULL, INDEX idproduto (idproduto), INDEX iduser (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE produtos (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(30) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, descricao TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, preco DOUBLE PRECISION DEFAULT NULL, estoque INT NOT NULL, foto VARCHAR(50) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, vendedor INT DEFAULT NULL, INDEX vendedor (vendedor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('ALTER TABLE compras ADD CONSTRAINT compras_ibfk_1 FOREIGN KEY (idproduto) REFERENCES produtos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
         $this->addSql('ALTER TABLE compras ADD CONSTRAINT compras_ibfk_2 FOREIGN KEY (iduser) REFERENCES usuarios (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
         $this->addSql('ALTER TABLE carrinho ADD CONSTRAINT carrinho_ibfk_1 FOREIGN KEY (idproduto) REFERENCES produtos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
         $this->addSql('ALTER TABLE carrinho ADD CONSTRAINT carrinho_ibfk_2 FOREIGN KEY (iduser) REFERENCES usuarios (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
         $this->addSql('ALTER TABLE produtos ADD CONSTRAINT produtos_ibfk_1 FOREIGN KEY (vendedor) REFERENCES usuarios (id) ON UPDATE NO ACTION ON DELETE NO ACTION');        
    }

    public function down(Schema $schema): void
    {
       // this down() migration is auto-generated, please modify it to your needs
       $this->addSql('ALTER TABLE compras DROP FOREIGN KEY compras_ibfk_1');
       $this->addSql('ALTER TABLE compras DROP FOREIGN KEY compras_ibfk_2');
       $this->addSql('ALTER TABLE carrinho DROP FOREIGN KEY carrinho_ibfk_1');
       $this->addSql('ALTER TABLE carrinho DROP FOREIGN KEY carrinho_ibfk_2');
       $this->addSql('ALTER TABLE produtos DROP FOREIGN KEY produtos_ibfk_1');
       $this->addSql('DROP TABLE usuarios');
       $this->addSql('DROP TABLE compras');
       $this->addSql('DROP TABLE carrinho');
       $this->addSql('DROP TABLE produtos');
    }
}

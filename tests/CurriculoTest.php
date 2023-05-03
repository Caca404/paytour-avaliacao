<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Curriculo;

    class CurriculoTest extends TestCase
    {
        public function testCurriculoNomeEmpty()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setNome('');
        }

        public function testCurriculoNomeTooLarge()
        {
            $curriculo = new Curriculo();
            $this->expectException(\LengthException::class);
            
            $curriculo->setNome("Teresa Cristina Maria Josefa Gaspar Baltasar Melchior 
                Januária Rosalía Lúcia Francisca de Assis Isabel Francisca de Pádua Donata 
                Bonosa Andréia de Avelino Rita Liutgarda Gertrude Venância Tadea Spiridione 
                Roca Matilde de Bourbon-Duas Sicílias");
        }

        public function testCurriculoEmailInvalid()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setEmail('');
        }

        public function testCurriculoTelefoneEmpty()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setTelefone('');
        }

        public function testCurriculoTelefoneInvalid()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setTelefone('849848948944849484');
        }

        public function testCurriculoCargoEmpty()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setCargo('');
        }

        public function testCurriculoCargoTooLarge()
        {
            $curriculo = new Curriculo();
            $this->expectException(\LengthException::class);
            
            $curriculo->setCargo('Todas estas questões, devidamente ponderadas, 
                levantam dúvidas sobre se o desenvolvimento contínuo de distintas formas de atuação 
                exige a precisão e a definição dos procedimentos normalmente adotados nos locais.');
        }
        
        public function testCurriculoEscolaridadeInvalid()
        {
            $curriculo = new Curriculo();
            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setEscolaridade('');
        }

        public function testCurriculoFileInvalidType()
        {
            $curriculo = new Curriculo();
            $file = tmpfile();

            $this->expectException(\InvalidArgumentException::class);
            
            $curriculo->setFile($file);
        }

        public function testCurriculoObservacoesTooLarge()
        {
            $curriculo = new Curriculo();

            $this->expectException(\LengthException::class);
            
            $curriculo->setObservacoes("Todas estas questões, devidamente ponderadas, 
                levantam dúvidas sobre se o desenvolvimento contínuo de distintas formas de atuação 
                exige a precisão e a definição dos procedimentos normalmente adotados nos locais.");
        }

        public function testCurriculoDateTimeInvalid()
        {
            $curriculo = new Curriculo();

            $this->expectException(\Exception::class);
            
            $curriculo->setDateTime("Alo");
        }
    }
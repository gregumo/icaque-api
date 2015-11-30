<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Nelmio\Alice\Fixtures;

class LoadFixtureData implements FixtureInterface
{
   public function load(ObjectManager $manager)
   {
       // pass $this as an additional faker provider to make the "groupName"
       // method available as a data provider
       Fixtures::load(__DIR__.'/fruits.yml', $manager, ['providers' => [$this]]);
       Fixtures::load(__DIR__.'/vegetables.yml', $manager, ['providers' => [$this]]);
       Fixtures::load(__DIR__.'/persons.yml', $manager, ['providers' => [$this]]);
       Fixtures::load(__DIR__.'/baskets.yml', $manager, ['providers' => [$this]]);
   }

   public static function fruitName()
   {
       $names = ["Abricot", "Airelle", "Alkékenge", "Amande", "Amélanche", "Ananas", "Arbouse", "Asiminier trilobé", "Avocat", "Banane", "Bergamote", "Bigarade", "Brugnon", "Canneberge", "Cassis", "Cerise", "Châtaigne", "Citron", "Clémentine", "Coing", "Cornouiller du Canada", "Cynorrhodon", "Datte", "Épine-vinette", "Figue", "Figue de barbarie", "Fraise", "Framboise", "Grenade", "Griotte", "Groseille", "Jujube", "Kaki", "Kiwi", "Lime", "Litchi", "Mandarine", "Marron", "Melon", "Mirabelle", "Mûre", "Myrte", "Myrtille", "Nèfle", "Nèfle du Japon", "Noisette", "Noix", "Olive", "Orange", "Patate", "Pamplemousse", "Pastèque", "Pêche", "Pistache", "Plaquebière", "Chicouté", "Poire", "Bigarade", "Citron vert", "Combava", "Kumquat", "Attier", "Cachiman", "Cherimole", "Corossol", "Acérola", "Ananas", "Avocat", "Banane", "Cacao (fèves)", "Caïmite", "Carambole", "Cerise de Cayenne", "Durian", "Fe'i", "Fruit-à-pain", "Fruit de la passion", "Girembelle", "Goyave", "Icaque", "Jacque", "Jambose rouge", "Kiwano", "Litchi", "Longane", "Mangoustan", "Mangue", "Melon", "Mombin", "Myrobolan", "Nèfle du Japon", "Noix de cajou", "Noix de coco", "Noix de muscade", "Pain de singe", "Papaye", "Barbadine", "Grenadelle", "Grenadille", "Pomme liane", "Pepino", "Physalis", "Pitaya", "Pomme de cajou", "Pomme de lait", "Prune de Cythère", "Quenette", "Ramboutan", "Salak", "Sapote", "Sapotille", "Tamarillo", "Tamarin", "Tamarin des Indes", "Tamarin d'Inde", "Taxo", "Yuzu"];

       return $names[array_rand($names)];
   }
   public static function vegetableName()
   {
       $names = ["ail cultivé","ail d'Orient","ail rocambole","amarante","ansérine bon-henri","añu","arachide","arroche","artichaut","asperge","aubergine","avocat","azuki","bambou","banane plantain","bardane","baselle","basilic","bénincasa","bette à carde","betterave","blette","brèdes","brocoli","brocoli chinois","bunias d'Orient","calebasse","canna comestible","capucine tubéreuse","cardon","carotte","céleri","céleri-rave","cerfeuil tubéreux","châtaigne d'eau","châtaigne de terre","chayote","chénopode Bon-Henri","chervis","chia","chicon","chou","chou de Bruxelles","chou cabus","chou chinois","chou-fleur","chou frisé","chou-navet","chou palmier","chou palmiste","chou de Pékin","chou-rave","chou romanesco","christophine","ciboule","ciboule de Chine","ciboulette","citrouille","claytone de Cuba","coqueret du Pérou","concombre","cornichon","courge","courgette","courge cireuse","courge musquée","courge de Siam","cresson alénois","cresson de fontaine","cresson des jardins","cresson de terre","cresson d'hiver","cresson de Para","crosne du Japon","curcuma","dachine","daikon","dolique asperge","dolique lablab","échalote","endive","épinard","épinard de Malabar","fenouil","fève","ficoïde glaciale","frisée","flageolet","gingembre","glycine tubéreuse","gombo","gourde","grande bardane","grelos","guimauve officinale","haricot","haricot d'Espagne","haricot de Lima","haricot kilomètre","haricot mungo","hélianthi","houttuynia","igname ailée","jaque","jujube","kancon","konbu kiwi","laitue","lentille","lys asiatique comestible","luffa","maceron","mâche","maïs doux","manioc","margose","mauve","marron mizuna","momordique","menthe","navet","niébé","nombril de Vénus","oca du Pérou","oignon","oignon de Chine","okra","onagre","ortie","oseille","pak choï","panais","pastèque","patate douce","pâtisson","persil","petit pois","périlla","pe-tsaï","physalis","piment","pissenlit","poireau","poirée","poire de terre","pois sec","pois carré","pois chiche","pomme de terre","pois d'Angole","pois sabre","poivron","potiron","potimarron","pourpier","pousses de bambou","Prune","radis","radis noir","radis mougri","radis du Japon","raifort","romaine","roquette","rutabaga","rhubarbe","salicorne","salsifis","scarole","scorsonère","serpent végétal","shiso","soja","souchet comestible","Udo","taro","tétragone cornue","tinda","tomate","topinambour","turmeric","wakame","wasabi","yin tsoï"];

       return $names[array_rand($names)];
   }

    /**
     * build a sample image URL for given dimension and type
     *
     * @param string $width  The image width
     * @param string $height The image height
     * @param string $type   Could be one the following : abstract | animals | business | cats | city | food | nightlife | fashion | people | nature | sports | technics | transport
     *
     * @return string The image url
     */
    public static function imageLink($width = 200, $height = 150, $type = '')
    {
        return sprintf('http://%s/%d/%d/%s', "lorempixel.com", $width, $height, $type);
    }
}

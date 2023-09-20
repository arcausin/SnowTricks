<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Grab');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Flip');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Slide');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Frontside');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Backside');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Straight airs');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Spins');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Inverted rotations');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Stalls');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Tweaks');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Miscellaneous');
        $manager->persist($category);

        $manager->flush();

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Slide']));
        $trick->setName('Noseblunt');
        $trick->setSlug('noseblunt');
        $trick->setDescription("A slide performed where the rider's trailing foot passes over the rail on approach, with their snowboard traveling perpendicular and leading foot directly above the rail or other obstacle (like a noseslide). When performing a frontside noseblunt, the snowboarder is facing downhill. When performing a backside noseblunt, the snowboarder is facing uphill.");
        $trick->setIllustration('Snowboard-Wallpaper-AlvaroVogel-Skeena-BC-SilvanoZeiter-featured-64de5664b29e5.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 16:39:46"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 12:11:45"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Flip']));
        $trick->setName('Chicane');
        $trick->setSlug('chicane');
        $trick->setDescription("A chicane is a rarely done trick that involves doing a frontside 180 with a front flip on the horizontal axis. Opposite of the 90 roll, the chicane is frontside 90, tuck front flip, 90 degrees more to land switch, or vice versa.");
        $trick->setIllustration('XMAS-AlvaroVogel-Layback-SaasFee-AY1Q1691-MattGEORGES-wallpaper-featured-64de566cb83e6.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 16:39:58"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 12:00:41"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Straight airs']));
        $trick->setName('Switch ollie');
        $trick->setSlug('switch-ollie');
        $trick->setDescription("While riding switch, the snowboarder performs an ollie.");
        $trick->setIllustration('Snowboard-Wallpaper-FredrikEvensen-DanielTengs-featured-64de5673c0612.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 16:40:13"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:59:49"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Spins']));
        $trick->setName('Alley-oop');
        $trick->setSlug('alley-oop');
        $trick->setDescription("An alley-oop is a spin performed in a halfpipe or quarterpipe in which the spin is rotated in the opposite direction of the air. For example, performing a frontside rotation on the backside wall of a halfpipe, or spinning clockwise while traveling right-to-left through the air on a quarterpipe would mean the spin was alley-oop.");
        $trick->setIllustration('MatSchaer-BS720-Stranda-Matt-Georges-featured-64de6ff5cd065.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 19:07:33"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:58:52"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Inverted rotations']));
        $trick->setName('Underflip');
        $trick->setSlug('underflip');
        $trick->setDescription("A backflip with a frontside 180 on the vertical axis, as opposed to the frontside cork 540, which is typically performed more off-axis.");
        $trick->setIllustration('Snowboard-Wallpaper-Night-Riding-Japan-Matt-GEORGES-64de7024e3b9a.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 19:08:20"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:57:44"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Grab']));
        $trick->setName('Bloody Dracula');
        $trick->setSlug('bloody-dracula');
        $trick->setDescription("A trick in which the rider grabs the tail of the board with both hands. The rear hand grabs the board as it would do it during a regular tail-grab but the front hand blindly reaches for the board behind the riders back.");
        $trick->setIllustration('lewis-sonvico-dave-crozier-ed-blomfield-2017-whitelines-wallpaper-1920x1080-f-64de732552ffe.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-17 19:21:09"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 12:01:21"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Stalls']));
        $trick->setName('Nose-stall');
        $trick->setSlug('nose-stall');
        $trick->setDescription("Similar to a board-stall, this variation involves stalling on the nose of the snowboard at the top of a transition or obstacle.");
        $trick->setIllustration('LukaJeromel-SwBs540Stale2-Zillertal-DominicZimmermann-featured-3-64df6b16a3e2d.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-18 12:59:02"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:56:37"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Tweaks']));
        $trick->setName('One-footed');
        $trick->setSlug('one-footed');
        $trick->setDescription("Tricks performed with one foot removed from the binding (typically the rear foot) are referred to as one-footed tricks. One footed tricks include fast plants in which the rear foot is dropped and initiates a straight air or rotation, the boneless, which is a fast-plant with a grab; and the no-comply, which is a front-footed fast plant.");
        $trick->setIllustration('Severin-van-der-meer-dark-WL-wallpaper-1920x1080-f-64df6b24154ce.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-18 12:59:16"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:56:07"));
        $manager->persist($trick);

        $trick = new Trick();
        $trick->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Miscellaneous']));
        $trick->setName('Sameway or Bagel');
        $trick->setSlug('sameway-or-bagel');
        $trick->setDescription("Like a Pretzel, but spinning 270° off the rail in the same direction as you got on.");
        $trick->setIllustration('snowboard-wallpaper-dom-harington-l2a-handplant-c-Samuel-McMahon-2015-cover-64df6b324d9ec.jpg');
        $trick->setCreatedAt(new \DateTimeImmutable("2023-08-18 12:59:30"));
        $trick->setUpdatedAt(new \DateTimeImmutable("2023-09-15 11:55:35"));
        $manager->persist($trick);

        $manager->flush();
    }
}

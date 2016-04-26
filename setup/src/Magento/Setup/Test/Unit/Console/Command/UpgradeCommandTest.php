<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Setup\Test\Unit\Console\Command;

use Magento\Setup\Console\Command\UpgradeCommand;
use Symfony\Component\Console\Tester\CommandTester;

class UpgradeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $installerFactory = $this->getMock('Magento\Setup\Model\InstallerFactory', [], [], '', false);
        $objectManagerProvider = $this->getMock('\Magento\Setup\Model\ObjectManagerProvider', [], [], '', false);
        $objectManager = $this->getMockForAbstractClass('Magento\Framework\ObjectManagerInterface');
        $state = $this->getMock('Magento\Framework\App\State', [], [], '', false);
        $objectManagerProvider->expects($this->once())->method('get')->willReturn($objectManager);
        $objectManager->expects($this->once())->method('get')->willReturn($state);
        $state->expects($this->once())->method('setAreaCode')->with('setup');
        $installer = $this->getMock('Magento\Setup\Model\Installer', [], [], '', false);
        $installer->expects($this->at(0))->method('updateModulesSequence');
        $installer->expects($this->at(1))->method('installSchema');
        $installer->expects($this->at(2))->method('installDataFixtures');
        $installerFactory->expects($this->once())->method('create')->willReturn($installer);
        $commandTester = new CommandTester(new UpgradeCommand($installerFactory, $objectManagerProvider));
        $commandTester->execute([]);
    }
}

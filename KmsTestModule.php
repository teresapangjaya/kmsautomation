<?php
namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class KmsTestModule extends BaseTestModule {
    public function start(){
        $windowHandlesBefore    = $this->driver->getWindowHandles();

        $this->writeLine("Start Login");
        $this->writeLine("Username: ".$this->username);
        $this->writeLine("Password: ".$this->password);
        $this->fillInputByName("userId", $this->username);
        $this->fillInputByName("password", $this->password);
        $this->addSmallDelay();
        $this->clickElementByName("login");

        $this->addSmallDelay();
        $this->switchToFrameId("menuFrame");
        $this->writeLine("Open dropdown MMS Menu");
        $this->openDropdown(WebDriverBy::id("mainMenum_0")); //MMS Menu
        $this->addMediumDelay();

        $this->switchToDefaultContent();
        $this->switchToFrameName("mainFrame");
        $this->writeLine("Click Registration (Dropdown)");
        $this->clickElementById("mainMenum_0_0"); //Registration
        $this->addSmallDelay();

        $this->switchToDefaultContent();
        $this->switchToFrameId("menuFrame");

        $this->writeLine("Click Registration");
        $this->clickElementById("mainMenum_2");
        $this->addSmallDelay();

        $this->writeLine("Click Create Registration");
        $this->clickElementById("mainMenum_3");
        $this->addMediumDelay();

        $this->switchToDefaultContent();
        $this->switchToFrameName("mainFrame");
        $this->writeLine("Click Search Icon for searching patient information");
        $this->clickElementByName("searchPatientIcon");
        $this->switchToDefaultContent();
        $this->addMediumDelay();
        // Switch current window to pop-up window
        $this->writeLine("Switch to other window");
        $windowHandlesAfter = $this->driver->getWindowHandles();
        $newWindowHandle    = array_diff($windowHandlesAfter, $windowHandlesBefore);
        $this->driver->switchTo()->window(reset($newWindowHandle));
        // Search patient by name
        $this->fillInputById("firstName", "vie");
        $this->clickElementByName("act");
        $this->addMediumDelay();
        // Choose first record
        $this->writeLine("Choose first record");
        $this->executeScript("$(\".roweven:first\").find(\"a\")[0].click();");
        $this->writeLine("Switch back to main window");
        $this->driver->switchTo()->window(reset($windowHandlesBefore));
        $this->addMediumDelay();

        // sectionAndServiceCode
        $this->switchToDefaultContent();
        $this->switchToFrameName("mainFrame");
        $this->writeLine("Fill service code (General Practice)");
        $this->chooseDropdownByName("sectionAndServiceCode", "OUT|SV01");
        $listOfSearchBtn = $this->driver->findElements(WebDriverBy::name("searchIcon"));
        foreach($listOfSearchBtn as $data){
            $this->writeLine("Find doctor...");
            if($data->getAttribute("href") == "javascript:openStaffSearch('staffId','D', 'mrNo')"){
                $data->click();
            }
        }
        $this->switchToDefaultContent();
        $this->addSmallDelay();
        $this->writeLine("Switch to other window");
        // Switch current window to pop-up window
        $windowHandlesAfter = $this->driver->getWindowHandles();
        $newWindowHandle    = array_diff($windowHandlesAfter, $windowHandlesBefore);
        $this->driver->switchTo()->window(reset($newWindowHandle));
        // Choose first record
        $this->writeLine("Choose Ariftama");
        $this->driver->findElement(WebDriverBy::partialLinkText("afitrama"))->click();
        $this->writeLine("Switch back to main window");
        $this->driver->switchTo()->window(reset($windowHandlesBefore));
        $this->addSmallDelay();

        $this->switchToDefaultContent();
        $this->switchToFrameName("mainFrame");
        $this->writeLine("Fill purpose");
        $this->fillInputByName("purpose", "General checkup");
        $this->writeLine("Click save button");
        $this->clickElementById("btnSave");
        $this->writeLine("Done");
    }
}
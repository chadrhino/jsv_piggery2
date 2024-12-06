<?php
 $pCount = $uCount = $bCount = $qCount = $sCount = $fCount = $cCount =  $vCount = '';

 $query = $db->query("SELECT * FROM pigs WHERE type IS NULL AND status = 1");
 $pCount = $query->rowCount();

 $sow_q = $db->query("SELECT * FROM pigs WHERE type IS NOT NULL");
 $sowCount = $sow_q->rowCount();

 $quer1 = $db->query("SELECT * FROM breed");
 $bCount = $quer1->rowCount();

 $quer2 = $db->query("SELECT * FROM classification");
 $cCount = $quer2->rowCount();
 
 $quer3 = $db->query("SELECT * FROM feed");
 $fCount = $quer3->rowCount();

 $quer4 = $db->query("SELECT * FROM vitamins");
 $vCount = $quer4->rowCount();

 $que5 = $db->query("SELECT * FROM quarantine");
 $quarantine = $que5->rowCount();
 
 $que6 = $db->query("SELECT * FROM sold");
 $sold = $que6->rowCount();

 $qu = $db->query("SELECT * FROM admin");
 $uCount = $qu->rowCount();

?>


<div class="w3-row-padding w3-margin-bottom dont-print">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $pCount;  ?> / <?= $sowCount ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Pigs / Sow</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-lock w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $quarantine;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Quarantine</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-cyan w3-padding-16">
        <div class="w3-left"><i class="fa fa-diamond w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $sold;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Sold</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-reorder w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $bCount;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Breeds</h4>
        </h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-black w3-padding-16">
        <div class="w3-left"><i class="fa fa-medkit w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $vCount;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Vitamins</h4>
        </h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-yellow w3-padding-16">
        <div class="w3-left"><i class="fa fa-stack-overflow w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $fCount;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Feed
        </h4>
      </div>
    </div><div class="w3-quarter">
      <div class="w3-container w3-green w3-padding-16">
        <div class="w3-left"><i class="fa fa-sort w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $cCount;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Classification</h4> 
        </h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $uCount;  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>

    
  </div>
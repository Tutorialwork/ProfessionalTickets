<h1>FAQ</h1>
<div class="faq">
  <ul>
    <?php
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM faq");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
      ?>
      <li onclick="show(<?php echo $row["ID"]; ?>)"><?php echo $row["QUESTION"]; ?> <i id="icon-<?php echo $row["ID"]; ?>" class="fas fa-plus"></i></li>
      <div id="answer-<?php echo $row["ID"]; ?>" style="display: none;">
        <p><?php echo $row["ANSWER"]; ?></p>
      </div>
      <?php
    }
     ?>
  </ul>
</div>
<script type="text/javascript">
function show(answer) {
  var x = document.getElementById("answer-"+answer);
  var icon = document.getElementById("icon-"+answer);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  if (icon.classList.contains("fa-plus")) {
    icon.classList.remove("fa-plus");
    icon.classList.add("fa-minus");
  } else {
    icon.classList.remove("fa-minus");
    icon.classList.add("fa-plus");
  }
}
</script>

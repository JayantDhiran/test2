<?php 
?>
<header>
    <div class="inst_header">
        <a href="./" class="web_ttl">Company</a>
        <span id="bars"><i class="fas fa-bars inst_bars"></i></span>        
    </div>
</header>

<script>
document.getElementById('bars').addEventListener('click',()=>{
    document.getElementById('sidebar').classList.toggle('mobsid');
});
</script>
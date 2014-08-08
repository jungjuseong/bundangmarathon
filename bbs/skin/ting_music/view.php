<script language="JavaScript">
function openNewWindow() {
    newWin = window.open('<?echo $dir;?>/song_play.php?<?echo "id=$id&no=$data[no]";?>','jukeboxwin','scrollbars=no,resizable=no height=1215 width=1375 top=50 left=50');//(1)
    setTimeout("newWin.close()", 5000000);
}
openNewWindow()
</script>
<script>

self.location='http://www.bundangmarathon.com/bbs/zboard.php?id=music';

</script>

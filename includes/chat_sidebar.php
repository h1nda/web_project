<div id="sidebar">
        <div id="sidebar-header">
            <h2>Chat</h2>
            <?php if (isset($_SESSION["username"])) {echo $_SESSION["username"];} else {echo $_SESSION["fn"];}; ?>
        </div>

        <div id="message-container">
        </div>
        
        <div id="message-input">
            <form id="message-form">
                <textarea id="message-text" name="text"></textarea>
                <input type="hidden" name="qid" value="<?php echo $qid; ?>">
                <button id="send-button" name="submit">Send</button>
            </form>
        </div>
    </div>
<script type="module" src="js/fetch_messages.js"></script>
<script src="js/send_message.js"></script>

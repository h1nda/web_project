<div id="sidebar">
        <div id="sidebar-header">
            <h2>Chat</h2>
            <p><?php if (isset($_SESSION["username"])) {echo $_SESSION["username"];} else {echo $_SESSION["fn"];}; ?></p>
        </div>

        <div id="message-container">
        </div>
        
        <div id="message-input">
            <form id="message-form">
                <textarea id="message-text" name="text"></textarea>
                <input type="hidden" name="qid" value="<?php echo $qid; ?>">
                <div id="pm">
                    <?php
                    if (isset($_SESSION["fn"])) {
                    echo "<input type=\"checkbox\" name=\"private\" value=\"1\"/>";
                    echo "<label>Private</label>";
                    }
                    ?>
                    <button id="send-button" name="submit">Send</button>
            </div>
            </form>
        </div>
    </div>
<script type="module" src="js/fetch_messages.js"></script>
<script src="js/send_message.js"></script>

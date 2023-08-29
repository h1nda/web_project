<div id="sidebar">
        <div id="sidebar-header">
            <h2>Chat</h2>
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
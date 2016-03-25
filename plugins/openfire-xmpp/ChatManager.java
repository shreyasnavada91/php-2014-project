package com.yourname.plugins.openfire;

import org.jivesoftware.openfire.session.ClientSession;
import org.jivesoftware.openframe.packet.Message;

import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

/**
 * Chat Manager - Manages chat sessions (2016 Openfire)
 */
public class ChatManager {
    
    private Map<String, ClientSession> activeChats = new ConcurrentHashMap<>();
    
    public void addChatSession(String userId, ClientSession session) {
        activeChats.put(userId, session);
        System.out.println("Chat session added for: " + userId);
    }
    
    public void removeChatSession(String userId) {
        activeChats.remove(userId);
        System.out.println("Chat session removed for: " + userId);
    }
    
    public int getActiveChatCount() {
        return activeChats.size();
    }
    
    public void broadcastMessage(String message) {
        for (Map.Entry<String, ClientSession> entry : activeChats.entrySet()) {
            ClientSession session = entry.getValue();
            if (session != null && session.getStatus() == ClientSession.Status.CONFIRMED) {
                Message msg = new Message();
                msg.setBody(message);
                session.deliver(msg);
            }
        }
    }
    
    public void sendPrivateMessage(String toUser, String message) {
        ClientSession session = activeChats.get(toUser);
        if (session != null) {
            Message msg = new Message();
            msg.setBody(message);
            session.deliver(msg);
            System.out.println("Private message sent to: " + toUser);
        } else {
            System.out.println("User not found: " + toUser);
        }
    }
}

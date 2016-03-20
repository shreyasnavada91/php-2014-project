package com.yourname.plugins.openfire;

import org.jivesoftware.openfire.PacketInterceptor;
import org.jivesoftware.openfire.Session;
import org.jivesoftware.openframe.packet.Message;
import org.jivesoftware.openframe.packet.Packet;

import java.util.concurrent.ConcurrentHashMap;
import java.util.Map;

public class ChatHandler implements PacketInterceptor {
    
    private Map<String, String> userStatus = new ConcurrentHashMap<>();
    
    @Override
    public void interceptPacket(Packet packet, Session session, boolean incoming, boolean processed) {
        if (packet instanceof Message) {
            Message message = (Message) packet;
            String from = message.getFrom();
            String body = message.getBody();
            
            if (incoming && !processed) {
                processChatMessage(from, body);
            }
        }
    }
    
    private void processChatMessage(String from, String message) {
        System.out.println("[" + from + "]: " + message);
        userStatus.put(from, "online");
        
        if (message != null && message.toLowerCase().contains("help")) {
            System.out.println("User requested help");
        }
    }
    
    public int getOnlineUsers() {
        int online = 0;
        for (String status : userStatus.values()) {
            if ("online".equals(status)) online++;
        }
        return online;
    }
}

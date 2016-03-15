package com.yourname.plugins.chat;

import org.jivesoftware.openfire.Plugin;
import org.jivesoftware.openfire.PluginManager;
import org.jivesoftware.openfire.XMPPServer;

import java.io.File;

public class ChatPlugin implements Plugin {
    private XMPPServer server;
    private PluginManager pluginManager;
    
    @Override
    public void initializePlugin(PluginManager manager, File pluginDirectory) {
        server = XMPPServer.getInstance();
        pluginManager = manager;
        System.out.println("ChatPlugin initialized: " + server.getName());
    }
    
    @Override
    public void destroyPlugin() {
        System.out.println("ChatPlugin destroyed");
    }
}

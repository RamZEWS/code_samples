package com.traveltogo.gateway;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

/**
 * Created by allinse on 30.09.16.
 */
@Controller
public class ControllerView {

    @RequestMapping("/")
    public String mainView(){
        return "loadApp.html";
    }
}

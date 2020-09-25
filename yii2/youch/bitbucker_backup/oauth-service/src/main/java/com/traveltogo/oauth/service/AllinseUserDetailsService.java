package com.traveltogo.oauth.service;

import com.traveltogo.oauth.entity.Users;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;

import java.util.HashSet;
import java.util.Set;

/**
 * Created by allinse on 05.09.16.
 */
@Service
public class AllinseUserDetailsService implements UserDetailsService {

    @Autowired
    private UsersService usersService;

    @Autowired
    private  RolesService rolesService;

    private Users user = new Users();

    public UserDetails loadUserByUsername(String login) throws UsernameNotFoundException {


        this.user = usersService.getUserByLogin(login);
        System.out.println(user.getRoles().getRole());

        Set<GrantedAuthority> GrantedRole = new HashSet();
        GrantedRole.add(new SimpleGrantedAuthority(user.getRoles().getRole()));

        UserDetails userDetails =
                new org.springframework.security.core.userdetails.User(user.getLogin(),
                        user.getPassword(),true, true,true, true,
                        GrantedRole);
        if (userDetails == null) {
            throw new UsernameNotFoundException(login);
        }
        return userDetails;

    }
}
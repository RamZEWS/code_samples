package com.traveltogo.oauth.service;

import com.traveltogo.oauth.entity.Users;
import com.traveltogo.oauth.repository.UsersRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.security.Principal;

/**
 * Created by allinse on 05.09.16.
 */
@Service
public class UsersServiceImpl implements UsersService {

    @Autowired
    private UsersRepository usersRepository;

    @Override
    @Transactional
    public Users getUserById(int id) {
        return null;
    }

    @Override
    @Transactional
    public Users getUserByLogin(String login) {
        return usersRepository.findByLogin(login);
    }

    @Override
    public Users getAuthenticationUser(){
        Principal principal = (Principal) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        Users users = getUserByLogin(principal.getName());
        return users;
    }

    @Override
    public Users create(Users users) {
        return null;
    }


}

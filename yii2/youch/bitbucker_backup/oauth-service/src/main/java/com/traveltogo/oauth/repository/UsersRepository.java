package com.traveltogo.oauth.repository;

import com.traveltogo.oauth.entity.Users;
import org.springframework.data.repository.CrudRepository;

/**
 * Created by allinse on 05.09.16.
 */
public interface UsersRepository extends CrudRepository<Users, Long> {
    Users findByLogin(String login);

    Users findById(int id);
}

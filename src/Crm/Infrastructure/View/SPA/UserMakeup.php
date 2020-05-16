<?php


namespace Cuadrik\Crm\Infrastructure\View\SPA;


class UserMakeup
{
    public static function execute($user)
    {

        return [
            'data' => [
                'username' => $user->username(),
                'displayName' => $user->displayName(),
                'firstname' => $user->firstname(),
                'lastname' => $user->lastname(),
                'email' => $user->email(),
                'photoURL' => "assets/images/avatars/".$user->photoUrl(),
                "settings"=>[
                    "layout"=>[
                        "style"=>"layout2",
                        "config"=>[
                            "scroll"=>"content",
                            "navbar"=>[
                                "display"=>true,
                                "folded"=>true,
                                "position"=>"left"
                            ],
                            "toolbar"=>[
                                "display"=>true,
                                "style"=>"fixed",
                                "position"=>"below"
                            ],
                            "footer"=>[
                                "display"=>false,
                                "style"=>"fixed",
                                "position"=>"below"
                            ],
                            "mode"=>"fullwidth"
                        ]
                    ],
                    "customScrollbars"=>true,
                    "theme"=>[
                        "main"=>"defaultDark",
                        "navbar"=>"defaultDark",
                        "toolbar"=>"defaultDark",
                        "footer"=>"defaultDark"
                    ]
                ],
                "shortcuts"=>[
                    "calendar",
                    "mail",
                    "contacts"
                ]
            ],
            'from' => "main-db",
            'role' => "admin",
//            'role' => $user->getRoles(),
            'uuid' => $user->uuid(),
//            ...
        ];



    }

}
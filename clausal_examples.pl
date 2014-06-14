dynamic woman/1, female/1.

modeh(woman(+person)).
modeb(female(+person)).

determination(woman/1, female/1).

%type information
person(jane).
person(susan).
person(mary).

%background knowledge

%positive examples
woman(jane) :- female(jane).
woman(susan) :- female(susan).
woman(mary) :- female(mary).

%negative examples


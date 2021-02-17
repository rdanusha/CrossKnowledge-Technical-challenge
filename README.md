# Technical challenge

Here is the description of what you'll need to implement on this technical challenge.

# Challenges

## 1. Cache function
Implement a function or class (it can be on the same file - `request.php`) to cache requests made with the existing code, preventing unecessary calls. You may use [this Redis module](https://github.com/phpredis/phpredis) as a cache service. Feel free to change the code within the existing functions, but do not alter their behaviour.

**Context**: Caching requests can be useful to avoid unecessary HTTP calls for the same resources, however, the resources can change during time, so it is important to keep in mind that cache needs to be invalidated at some point.

**Note**: You may use any Python version and import other modules, unless they implement cache services for the requests.

## 2. Date formatting
Implement a JavaScript code that replaces the value (`innerHTML` value) from elements with the class `js-date-format` with the formatted value of the time passed since the element initial time. The value within the elements will be a ISO date format (`2019-04-05T12:00:00.000Z` for example). It will be tested on Google Chrome.

Use the following format:
* 1 second ago OR X seconds ago
* 1 minute ago OR X minutes ago
* 1 hour ago OR X hours ago
* Date in ISO format (original format)

Working example:

![Working example](https://i.ibb.co/G59QXBd/example.gif)

**Note**: You may use ecmascript 6 features but must not use any framework or add any dependency.

## 3. Apply style
Implement the CSS code to make the component on `component.html` look like the desired mockup below. Add attributes as you may need, but do not use HTML tags as CSS selectors to implement the styles. It will be tested on Google Chrome.

Mockup:

![Desired mockup](https://i.ibb.co/Brh3jXQ/mockup.png)

**Note #1**: You should use new CSS features and add classes as you need, but try not to change the HTML structure.

**Note #2**: We recommend you try using [BEM](http://getbem.com/introduction/).

# Evaluation
This is a list of what will be evaluated in your code:
* Code is working as expected
* [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
* [Separation of concers](https://en.wikipedia.org/wiki/Separation_of_concerns)
* [Coding conventions](https://en.wikipedia.org/wiki/Coding_conventions) applied and [code consistency](https://medium.com/@jgefroh/why-consistency-is-one-of-the-top-indicators-of-good-code-352ba5d62020)
* [Code readability](https://deviq.com/code-readability/) and how you [name things](https://deviq.com/naming-things/)
* [Overengineering](https://en.wikipedia.org/wiki/Overengineering)
* Usage of BEM, if used
